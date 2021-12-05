function ajaxShowPeople(keyword, showPeople) {
    $.ajax({
        url: baseUrl + "/people/search",
        method: "get",
        data: {
            keyword: keyword
        },
        success: function (response) {
            console.log(response)
            if ((response).length !== 0) {
                showPeople(response);
            } else {
                $(".people").html("<h3 class='alert alert-danger'> There are no people to follow </h3>");
            }
        },
        error: function (xhr) {
            let code = xhr.status;
            console.log(xhr);
            console.log(code);
        },
        dataType: "json"
    })
}

$(document).ready(function(){
    var keyword = "";

   ajaxShowPeople(keyword, showPeople);

    //region SEARCH
    $("#keyword").on("keyup", function(){
        keyword = $(this).val().trim();

        //region CONSOLE.LOGS FOR SEARCH
        console.log("Key:" + keyword);
        //endregion

        ajaxShowPeople(keyword, showPeople);
    });

    //endregion



    function showPeople(users){
        console.log(users)
        let output = ``;
        for(let user of users){
            output += `
<div class="col-lg-3 d-flex flex-column align-items-center text-center mb-4 mt-2">
                    <div class="user-icon"> `;
                        if (user.profile_image !== null){
                            output +=  ` <img
                                src="${publicImagesStorage + '/avatars/' + user.profile_image}"
                                alt="profile pic"
                                class="mb-3"
                                width="70" height="90"
                            />`;
                        }else if(user.profile_image === null && user.gender.name === "male"){
                            output +=  `<img
                                src="${imagesFolder + '/default-avatar.png'}"
                                alt="profile pic"
                                class="mb-3"
                                width="70" height="90"
                            />`;
                        }else if (user.profile_image === null && user.gender.name === "female"){
                            output +=  `<img
                                src="${imagesFolder + '/woman-avatar.png'}"
                                alt="profile pic"
                                class="mb-3"
                                width="70" height="90"
                            />`;
                        }

         output += `           </div>
                    <div>
                        <h3 class="profile_title">${user.first_name }  ${user.last_name } </h3>
                        <h4 class="profile_subtitle">${user.username }</h4>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="${baseUrl + '/user/friends/' + user.id}" class="btn btn-sm btn-outline-secondary mr-2">
                      <i class="fas fa-users actionsIcons"></i>
${user.friends.length}</a>
                       <a href="#" class="btn btn-outline-danger addFriend" data-id="${user.id}">
                       <i class="fas fa-user-plus actionsIcons"></i>
                       Follow </a>
<a href="${baseUrl + '/friends/' + user.id}" class="btn btn-sm btn-outline-secondary ml-2">
                            <i class="fas fa-eye actionsIcons"></i>
                            View
                        </a>
                    </div>
                </div>
            `;
        }

        $('.people').html(output);
    }



    function addFriend(id) {
        console.log('tu')
        console.log(id)
        $.ajax({
            url:baseUrl + "/addFriend",
            method: "POST",
            data: {
                id: id,
                _token: token
            },
            success: function (response) {
                console.log(response)
                alert(response.msg)

                showPeople(response.data);
            },
            error: function (xhr) {
                let code = xhr.status;
                console.log(xhr);
                console.log(code);
            },
            dataType: "json"
        })
    }

    function removeFriend(id) {
        console.log('tu')
        console.log(id)
        $.ajax({
            url: baseUrl + "/removeFriend",
            method: "POST",
            data: {
                id: id,
                _token: token
            },
            success: function (response) {
                console.log(response)
                alert(response.msg)

                showPeople(response.data);
            },
            error: function (xhr) {
                let code = xhr.status;
                console.log(xhr);
                console.log(code);
            },
            dataType: "json"
        })
    }


    $(document).on("click",'.addFriend', function (e) {
        console.log("add")
        e.preventDefault();
        var id = parseInt($(this).data('id'));
        console.log(id)
        addFriend(id);
    })

    $(document).on("click",'.removeFriend', function (e) {
        console.log("remove")
        e.preventDefault();
        var id = parseInt($(this).data('id'));
        console.log(id)
        removeFriend(id);
    })
})
