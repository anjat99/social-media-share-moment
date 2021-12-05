function ajaxStories(keyword, sort, tags, page, showStories) {
    $.ajax({
        url: baseUrl + "/fetch-stories",
        method: "get",
        dataType: "json",
        data: {
            keyword: keyword,
            sort: sort,
            tags: tags,
            page: page
        },
        success: function (response) {
            console.log(response)
            if ((response.stories.data).length != 0) {
                showStories(response.stories.data, response.currentUser, response.stories.links, response.page);
            } else {
                $("#storiesFriends").html("<h3 class='text-danger notification mt-4'>Sorry, currently there is no published stories </h3>");
            }
        },
        error: function (xhr) {
            let code = xhr.status;
            console.log(xhr);
            console.log(code);
        },
        contentType : "application/x-www-form-urlencoded; charset=UTF-8",
        processData : true

    });
}
function getMyStories(statuses, page, showMyStories) {
    $.ajax({
        url: baseUrl + "/filter-stories",
        method: "get",
        dataType: "json",
        data: {
            statuses: statuses,
            page: page
        },
        success: function (response) {
            console.log(response)
            if ((response.stories.data).length != 0) {
                showMyStories(response.stories.data, response.currentUser, response.stories.links, response.stories.page);
            } else {
                $("#stories").html("<h3 class='text-danger notification mt-4'>Sorry, the story with your search doesn't exists. </h3>");
            }
        },
        error: function (xhr) {
            let code = xhr.status;
            console.log(xhr);
            console.log(code);
        },
        contentType : "application/x-www-form-urlencoded; charset=UTF-8",
        processData : true

    });
}
/* AJAX ADMIN*/
function ajaxFeed(url, method, data, success, error, dataType = "json", contentType = "application/x-www-form-urlencoded; charset=UTF-8", processData = true) {
    $.ajax({
        url: baseUrl + url,
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
    console.log(givenDate)
    const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    let currentDateTime = new Date(givenDate);
    let formattedDate = currentDateTime.getDate() + " " + months[currentDateTime.getMonth()] + "," + currentDateTime.getFullYear() + ", " + currentDateTime.getHours() + ":" + currentDateTime.getMinutes()
    return `${formattedDate}`;
}
//endregion


$(document).ready(function () {
    var path = window.location.href;
    const url = window.location.pathname;
    console.log(url)
    console.log(path)
    let currentYear = new Date().getFullYear();
    $('.current_year').html(currentYear);


    //region SHOW/HIDE FORM FOR REVIEWS
    $('#comment-add').hide();

    $("#btnShowFormAddComment").click(showFormAddComment);
    function showFormAddComment(e){
        e.preventDefault();
        console.log('show form for create comment');
        $(".comment-add").slideToggle("500");
    }
    //endregion
    $("#btnAddComment").on("click", insertComment);

    //region INSERTING REVIEWS
    function insertComment(e){
        e.preventDefault();
        console.log("insert comment");

        let message = $("#taMessageComment").val().trim();
        let post_id = $(this).data('story');

        let msgError = document.querySelector("#msgError");
        let errors = [];
        let valid=true;

        if(message === ''){
            errors.push('<b>The field for the text of comment is required!</b>')
            msgError.textContent = "The field for the text of comment is required!";
            alert ("The field for the text of comment is required!");
            valid = false;
        }
        
        if(valid){

            $.ajax({
                url: baseUrl + "/comments",
                method:"POST",
                data: {
                    'message':message,
                    'post_id': post_id,
                    '_token':token
                },
                success: function (data) {
                    console.log(data);
                    console.log(data.message);
                    
    
                    if(data.message === "Success"){
                      alert(data.message);
                        printComments(data.comments);
                      document.getElementById("taMessageComment").value = "";
                        $('#comment-add').hide();
                        window.location.reload();
                    }
                },
                error: function (xhr, error,status) {
                    let code = xhr.status;
                    console.log(xhr);
                    console.log(code);
                },
                dataType:"json"
            });
        }
    }
    //endregion

    //region PRINTING REVIEWS
    function printComments(data){
        console.log(data);

        let output = ``;
        for(let d of data){
            output += `
            <div class="comment-item">
                <div class="ri-pic">
                    <img src="${ url + "/assets/img/profileUser.png"}" alt="profile image">
                </div>
                <div class="ri-text">
                    <span> ${formatDate(d.created_at)}</span>

                    <h5>${d.user.first_name}  ${d.user.last_name}</h5>
                    <p>${d.message}</p>

                </div>
            </div>`;
        }

        $("#reviews").html(output);
    }
    //endregion


    var keyword = "";
    var sort = 0;
    var statuses = [];
    var tags = [];
    var page = 1;
    var pageS = 1;

    ajaxStories(keyword, sort, tags, page, showStories);
   // getMyStories(statuses, pageS, showMyStories);

    //region PAGINATION
    $(document).on("click",".page-link", function (e) {
        e.preventDefault();
        page = parseInt($(this).data('page'));
        if(url.indexOf("/feed") !== -1){
            ajaxStories(keyword, sort, tags, page, showStories);
        } else if(url.indexOf("/stories") !== -1){
            getMyStories(statuses, pageS, showStories);
        }


    })
    //endregion

    //region SEARCH
    $("#keyword").on("keyup", function(){
        keyword = $(this).val().trim();
        ajaxStories(keyword, sort, tags, page, showStories);
    });
    //endregion

    //region SORT BY NAME AND PRICE - ASC/DESC
    $("#sort").on("change", function(){
        sort = $(this).val();
        ajaxStories(keyword, sort, tags, page, showStories);

    });
    //endregion

    //region FILTER BY SERVICES
    $(".tags").on("change", function(e){
        e.preventDefault();

        let tag = parseInt($(this).val());
        console.log(tag);

        tags.includes(tag) ?  tags.splice (tags.indexOf(tag), 1) : tags.push(tag)
        console.log(tags);

        ajaxStories(keyword, sort, tags, page, showStories);
    });
    //endregion

    //region PRINTING BLOGS AND PAGINATION
    function showStories(stories, currentUser, pages, currentPage) {
        let output = ``;

      stories.forEach(story => {
          // console.log(story.user)
          output += `
                <div class="post-container">
                  <div class="post-row">
                      <div class="user-profile">`;

                            if (story.user.profile_image !== null) {
                                output += ` <img src="${publicImagesStorage + '/avatars/' + story.user.profile_image}" alt="profile pic" />`;
                            }else{
                                if (story.user.gender.name === "male"){
                                    output += ` <img src="${imagesFolder + '/default-avatar.png'}" alt="profile pic" />`;
                                }else if (story.user.gender.name === "female"){
                                    output += ` <img src="${imagesFolder + '/woman-avatar.png'}" alt="profile pic" />`;
                                }
                            }
                 output += `
        <div>
            <p>${story.user.first_name} ${story.user.last_name}</p>
            <span>Last updated:  ${story.updated_at == null ? formatDate(story.published_at) : formatDate(story.updated_at)}`;

                 output += `</span>

                            </div>
                        </div>

                    </div>

                    <p class="post-text">
                        <a href="${baseUrl + '/feed-stories/' + story.id}" class="text-decoration-none text-dark mr-1">
                            <h4 class="profile_title">${story.caption}</h4>
                         </a>
                          <h5 class="profile_subtitle">
<i class="fas fa-map-marker-alt"></i>
${story.location.name}</h5>

                         <br>`;

                          for (let tag of story.tags) {
                              output += `<p class="story_tag alert alert-secondary float-left mr-2">#${tag.title}</p>`;
                              if (!(tag === (story.tags.length - 1))) {
                                  output += ` `;
                              }
                          }

                 output += `  </p>
                    <img src="${publicImagesStorage + '/stories/' +  story.cover}" class="post-img" width="150" height="250">
                    <div class="post-row">
                        <div class="activity-icons">
                            <div>
                                <img src="${imagesFolder + '/comments.png'}">
                                 ${story.comments.length} comments
                            </div>
                        </div>
                    </div>
                </div>`;
        });

        var outputPage = ``;
        if(pages.length <= 3){
            outputPage += "";
        }else{
            outputPage += `<nav class="bg-transparent">
                            <ul class="pagination">`
        }

        var lastPage = 0;
        //region PRINTING PAGINATION
        for(page of pages){
            if(pages.length <= 3){
                outputPage += "";
            }else{
                outputPage += `
                        <li class="page-item ${page.active ? 'active' : ''}" >
                            <a class="page-link" data-page="${labelPage(currentPage,page.label,lastPage)}" href="#">${page.label}</a>
                        </li>`;
                lastPage++;
            }
        }
        function labelPage(currentPage, label, lastPage){
            if (label === "Next &raquo;"){
                lastPage--;
                if (parseInt(currentPage) + 1 <= lastPage)
                    return `${parseInt(currentPage) + 1}`
                else return 1
            }else if(label === "&laquo; Previous"){
                if (currentPage - 1 > lastPage)
                    return `${currentPage - 1}`
                else return 1
            }else
                return `${page.label}`
        }
        //endregion
        outputPage += `</ul>
                        </nav>`

        $("#storiesFriends").html(output);
        $( "#storiesFriends" ).append( $(outputPage) );
    }
    //endregion

    // region SORT BY STATUS
    $(".statuses").on("change", function(e){
        e.preventDefault();
        let status = parseInt($(this).val());
        statuses.includes(status) ? statuses.splice (statuses.indexOf(status), 1) : statuses.push(status)
        getMyStories(statuses, pageS, showMyStories)
    });
    //endregion

    function showMyStories(stories, currentUser, pages, currentPage ){
        let output = ``;
        stories.forEach(story => {
            output += `
                <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                    <div class="card">
                        <img src="${publicImagesStorage + '/stories/' +  story.cover}" class="card-img-top" alt="..." width="150" height="150">
                        <div class="card-body">
                             <h4 class="card-title profile_title">${story.caption}</h4>
                          <h5 class="profile_subtitle">
                          <i class="fas fa-map-marker-alt"></i>
${story.location.name}</h5>


                             <div class="d-flex justify-content-between align-items-center">
                                <a href="${baseUrl + '/api-stories/' + story.id}" class="btn btn-primary">READ</a>
                                <div class="d-flex">
                                    <a href="${baseUrl + '/stories/' + story.id + '/edit'}" class="btn p-1" data-id="${story.id}">
                                        <i class="fa fa-edit actionsIcons"></i>
                                    </a>
                                    <a class="btn p-1 btnDeleteStory" href="#" data-id="${story.id}" title="delete story">
                                        <i class="fa fa-trash actionsIcons"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated ${story.updated_at == null ? formatDate(story.published_at) : formatDate(story.updated_at)}</small>
                        </div>
                    </div>
                </div>`;
        });

        let outputPage = ``;
        outputPage += pages.length <= 3 ? "" : `<nav class="bg-transparent">
                            <ul class="pagination">`;

        let lastPage = 0;
        //region PRINTING PAGINATION
        for(page of pages){
            if(pages.length <= 3){
                outputPage += "";
            }else{
                outputPage += `
                        <li class="page-item ${page.active ? 'active' : ''}" >
                            <a class="page-link" data-page="${labelPage(currentPage,page.label,lastPage)}" href="#">${page.label}</a>
                        </li> `;
                lastPage++;
            }
        }
        function labelPage(currentPage, label, lastPage){
            if (label === "Next &raquo;"){
                lastPage--;
                if (parseInt(currentPage) + 1 <= lastPage)
                    return `${parseInt(currentPage) + 1}`
                else return 1
            }else if(label === "&laquo; Previous"){
                if (currentPage - 1 > lastPage)
                    return `${currentPage - 1}`
                else return 1
            }else
                return `${page.label}`
        }
        //endregion
        outputPage += `</ul>
                        </nav>`

        $("#stories").html(output);
        $( "#stories" ).append( $(outputPage) );
    }

    function getAllAlbums() {
        ajaxFeed(
            '/api/album-manage',
            'GET',
            {},
            function (data) {
                printAllAlbums(data.apiAlbums);
            },
            function (xhr, error) {
                console.log(error);
            }
        )
    }
    function printAllAlbums(data) {
        //console.log(data)
        let output =  ``;
        for (let item of data) {
            output += `
             <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                    <div class="card">
                        <div class="card-header">
                            ${item.category.name}
                        </div>`;
                if(item.stories.length > 0){
                    output += `<img src="${ (item.stories[item.stories.length-1]).cover}" class="card-img-top" alt="cover image" width="150" height="150">    `
                }else{
                    output += `
                      <div class="p-3 border d-flex justify-content-center align-items-center text-center">
                                    <a class="logo-text"  href="#">
                                        <h3>Share <span>Moments</span></h3>
                                    </a>
                                </div>
                      `
                }

                output += `
                        <div class="card-body">
                            <h5 class="card-title">  ${item.title}</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="${baseUrl + '/albums/' + item.id}" class="btn btn-primary">OPEN</a>
                                <div class="d-flex">
                                    <a href="${baseUrl + '/albums/' + item.id + '/edit'}" class="btn p-1" data-id="${item.id}">
                                        <i class="fa fa-edit actionsIcons"></i>
                                    </a>
                                    <a class="btn p-1 btnDeleteAlbum" href="#" data-number="${item.stories.length}" data-id="${item.id}" title="delete album">
                                        <i class="fa fa-trash actionsIcons"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
                </div>
        `;
        }

        output += `</tbody></table>`;
        $('.albums').html(output);
    }

    getAllAlbums();

    function deleteAlbum(id) {
        ajaxFeed(
            `/albums/${id}`,
            'DELETE',
            {
                id: id,
                _token: token
            },
            function (data) {
                // console.log(data)
                getAllAlbums();
                $('#responseAlbums').html("<div class='alert alert-info'><h3 class='text-dark text-danger'>" + data.message +  "</h3></div>")
            },
            function (data) {
                console.log(data);
            },
        )
    }



    $(document).on('click', '.btnDeleteAlbum', function (e) {
        e.preventDefault();
        let countStories = $(this).data('number');
        let id = $(this).data('id');
        if(countStories === 0){
            let isConfirmed = confirm("Are you sure that you want to delete this album?");

            if(isConfirmed){
                deleteAlbum(id);
            }

        }else{
            let isConfirmed = confirm("This album contains some stories, press OK if you still want to delete it.");

            if(isConfirmed){
                deleteAlbum(id);
            }
        }



    })

})
