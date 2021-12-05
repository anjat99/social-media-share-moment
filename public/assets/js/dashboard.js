/* AJAX */
function ajax(url, method, data, success, error, dataType = "json", contentType = "application/x-www-form-urlencoded; charset=UTF-8", processData = true) {
    $.ajax({
        url: baseUrlAdmin + url,
        method: method,
        data: data,
        dataType: dataType,
        success: success,
        error: error,
        contentType: contentType,
        processData: processData,
    });
}
function cutText(content, maxLength = 80, cutToLength = 50){
    if (content.length <= maxLength){
        return `${content}`;
    }else{
        let newContent = "";

        newContent += content.substring(0,cutToLength);
        newContent += "...";
        return `${newContent}`;
    }
}
function formatDate(givenDate){
<!--  June 21 2021, 13:40-->
    const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    let currentDateTime = new Date(givenDate);
    let formattedDate = currentDateTime.getDate() + " " + months[currentDateTime.getMonth()] + "," + currentDateTime.getFullYear() + ", " + currentDateTime.getHours() + ":" + currentDateTime.getMinutes()
    return `${formattedDate}`;
}
function printState(state, returnValueTrue, returnValueFalse){
    if (state == 0){
        return `${returnValueTrue}`;
    }else{
        return `${returnValueFalse}`;
    }
}

$(document).ready(function(){
    feather.replace();

var path = window.location.href;
$("#sidebarMenu .sidebar-sticky .nav-sidebar .nav-item a.nav-link").each(function() {
    if (this.href === path) {
        $(this).addClass("active");
    }
});

function getAllCategories() {
    ajax(
        '/api/categories-manages',
        'GET',
        {},
        function (data) {
            printAllCategories(data.apiCategories);
            // console.log(data)
        },
        function (xhr, error) {
            console.log(error);
        }
    )
}
function getAllLocations() {
    ajax(
        '/api/location-manages',
        'GET',
        {},
        function (data) {
            printAllLocations(data.apiLocations);
            // console.log(data)
        },
        function (xhr, error) {
            console.log(error);
        }
    )
}
function getAllTags() {
    ajax(
        '/api/tags-manages',
        'GET',
        {},
        function (data) {
            printAllTags(data.apiTags);
            // console.log(data)
        },
        function (xhr, error) {
            console.log(error);
        }
    )
}

function printAllCategories(data) {
    let output = `
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>NAME</th>
                    <th>DESCRIPTION</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>`;

    for (let item of data) {
        output += `
            <tr>
                    <td>${item.id}</td>
                    <td>${item.name}</td>
                    <td>${item.description}</td>
                    <td>
                        <a class="btn" href="${baseUrlAdmin + '/categories/' + item.id + '/edit'}" >
                        <i class="fa fa-edit"></i>
                        </a>
                    </td>
            </tr>
        `;
    }

    output += `</tbody></table>`;
    $('.categoriesAdmin').html(output);
}
function printAllLocations(data) {
    let output = `
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>COUNTRY NAME</th>
                </tr>
            </thead>
            <tbody>`;

    for (let item of data) {
        output += `
            <tr>
                <td>${item.id}</td>
                <td>${item.name}</td>
            </tr>
        `;
    }

    output += `</tbody></table>`;
    $('.locationsAdmin').html(output);
}
function printAllTags(data) {
    let output = `
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>TAG NAME</th>
                </tr>
            </thead>
            <tbody>`;

    for (let item of data) {
        output += `
            <tr>
                <td>${item.id}</td>
                <td>${item.title}</td>
            </tr>
        `;
    }

    output += `</tbody></table>`;
    $('.tagsAdmin').html(output);
}

getAllCategories();
getAllLocations();
getAllTags();
getAllMessages();

function filterByDateActivities(){
    var dateFrom = $("#dateFrom").val();
    var dateTo = $("#dateTo").val();
    getActivities(1,dateFrom,dateTo)
}
function deleteMessage(id) {
        ajax(
            `/messages/${id}`,
            'DELETE',
            {
                id: id,
                _token: token
            },
            function (data) {
                console.log(data)
                getAllMessages();
                $('#responseMessages').html("<div class='alert alert-info'><h3 class='text-dark text-danger'>" + data.message +  "</h3></div>")
                window.location.reload();
            },
            function (data) {
                console.log(data);
            },
        )
    }

$(document).on('change', '.date', filterByDateActivities)
$(document).on('click', '.btnDeleteMessage', function (e) {
    // console.log('delete message')
    e.preventDefault();
    let id = $(this).data('id');
    deleteMessage(id);
})


});

function printActivities(response){
    console.log(response)
    let output = `<table class="table table-striped table-sm ">
                            <thead>
                            <tr>
                                <th>FROM (IP ADDRESS)</th>
                                <th>EMAIL</th>
                                <th>USERNAME</th>
                                <th>ROLE</th>
                                <th>ACTIVITY</th>
                                <th>DATE</th>
                            </tr>
                            </thead>
                            <tbody id="activities">`
    for(d of response){
        output+=`
            <tr>
                <th class="text-center">${d.ip_address}</th>
                <td class="text-center">${d.user.email}</td>
                <td class="text-center">${d.user.username}</td>
                <td class="text-center">
                    ${d.user.role_id == 2 ? "user" : "admin"}
                </td>
                <td class="text-center">${d.activity}</td>
                <td class="text-center">${d.date}</td>
            </tr>
    `
    }
    output += `</tbody></table>`;
    $("#no-activities").html(output)
}
function getActivities(page,dateFrom,dateTo){
    const caller = arguments.callee.caller.name;
    $.ajax({
        url: baseUrlAdmin + "/activities-filter",
        method: "GET",
        data: {
            page,
            dateFrom,
            dateTo
        },
        dataType: "json",
        success: function (response) {
            // console.log(response)
            if((response.data).length != 0){
                printActivities(response.data)
            }else{
                $("#no-activities").html(`<h3 class='text-danger text-center'>There are no activities for the requested date range. </h3>`)
            }

            if(caller === 'filterByDateActivities')
                printPagination(response.last_page,response.current_page)
            if(caller === 'showMore')
                changeActiveLink(response.current_page)
        },
        error: function (response){
            console.log(response)
        }
    });
}
function printAllMessages(data) {
    let output = `
         <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>SUBJECT</th>
                <th>MESSAGE</th>
                <th>DATE OF SENT</th>
                <th>IS READ?</th>
                <th>ACTIONS</th>
            </tr>
            </thead>
            <tbody>`;

    for (let item of data) {
        output += `
            <tr>
                <td>${item.id}</td>
                <td>${item.name} </td>
                <td>${item.email}</td>
                <td>${item.subject}</td>
                <td>${cutText(item.message)}</td>
                <td>${ formatDate(item.created_at)}</td>
                <td>${ printState(item.is_read, "UNREAD", "READ")}</td>
                <td>
                    <a class="btn" href="${baseUrlAdmin + '/messages/' + item.id }" >
                        <i class="fas fa-info-circle"></i>
                        <span data-feather="info"></span>
                    </a>
                    <a class="btn btnDeleteMessage" href="#"  data-id="${item.id}">
                        <i class="fa fa-trash"></i>
                        <span data-feather="delete"></span>
                    </a>
                </td>
            </tr>
        `;
    }

    output += `</tbody></table>`;
    $('.messagesAdmin').html(output);
}
function getAllMessages(page) {
    const caller = arguments.callee.caller.name;
    ajax(
        '/api/messages-manages',
        'GET',
        {page},
        function (response) {
            console.log(response.apiMessages.data)
            if((response.apiMessages.data).length !== 0){
                printAllMessages(response.apiMessages.data);
            }

            if(caller === 'showMore'){
                changeActiveLink(response.apiMessages.current_page)
            }

        },
        function (xhr, error) {
            console.log(error);
        }
    )
}
