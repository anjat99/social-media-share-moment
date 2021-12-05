function validateField(value, msgErrorName, field) {
    let valid = true;
    console.log(value)
    console.log("Type: " + typeof (value))
    if (value === '') {
        msgErrorName.textContent = `The field for the ${field} of contact message is required!`;
        valid = false;
    }else{
        msgErrorName.textContent = " ";
        valid = true;
    }
    return valid;
}
function printErrors(errors) {
    let content = '<ul class="alert alert-danger mt-4 d-flex flex-column justify-content-center align-items-center">';
    for(error of Object.keys(errors)) {
        content += '<li>'+ errors[error][0] +'</li>';
    }
    content += '</ul>';
    $(".errors").html(content);
}

window.addEventListener('DOMContentLoaded', () => {
    feather.replace();

    var path = window.location.href;
    const url = window.location.pathname;
    console.log(url)
    console.log(path)

    $("#sidebarMenuUser .sidebar-sticky .nav-sidebar .nav-item a.nav-link").each(function() {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    var userIcon = document.querySelector("#userIcon");
    var settingsMenu = document.querySelector('.settings-menu');
    // var darkBtn = document.getElementById('dark-btn');
    var linkCollection =document.getElementById("collection");
    var closeModalCollection =document.getElementById("zatvoriModalCollections");
    var linkAddPostForm=document.getElementById("linkOpenCreateNewPost");
    var modalCollection = document.getElementById('modalCollection');

    // darkBtn.addEventListener("click", toggleMode);
    userIcon.addEventListener("click", toggleSettingsMenu);
    linkCollection.addEventListener("click", openModalCollections);
    closeModalCollection.addEventListener("click", closeModalCollections);

    function toggleMode() {
        darkBtn.classList.toggle('dark-btn-on');
        document.body.classList.toggle('dark-theme');
    }
    function toggleSettingsMenu() {
        settingsMenu.classList.toggle('settings-menu-height')
    }
    function openModalCollections() {
        document.getElementById("modalCollection").style.display="block"
    }
    function closeModalCollections() {
        document.getElementById("modalCollection").style.display="none"
    }
    window.onclick = function(event) {
        if (event.target === modalCollection) {
            modalCollection.style.display = "none";
        }
    }

    if(url.indexOf("/feed") !== -1){
        console.log(linkAddPostForm);
        linkAddPostForm.addEventListener("click", () => {
            redirectToPage("/stories/create");
        });

    } else if(url.indexOf("/stories") !== -1){
        console.log("stories");
    }else if(url.indexOf("/society") !== -1){
        console.log("society");
        $("#navSociety nav").css("background-color", "transparent");
    }
    else if(url.indexOf("/contact") !== -1){
        console.log("contact");
        $("#btnSendMessage").on("click", sendMessage);
        function sendMessage(e){
            e.preventDefault();
            console.log('send message');

            let name = $("#tbNameContact").val().trim();
            let email = $("#tbEmailContact").val().trim();
            let subject = $("#tbSubjectContact").val().trim();
            let message = $("#taMessageContact").val().trim();

            let msgErrorName = document.querySelector(".msgErrorName");
            let msgErrorEmail = document.querySelector(".msgErrorEmail");
            let msgErrorSubj = document.querySelector(".msgErrorSubj");
            let msgErrorMessage = document.querySelector(".msgErrorMessage");

            let nameField = $("#tbNameContact").data('field');
            let emailField = $("#tbEmailContact").data('field');
            let subjField = $("#tbSubjectContact").data('field');
            let msgField = $("#taMessageContact").data('field');


            validateField(name, msgErrorName, nameField);
            validateField(email, msgErrorEmail, emailField);
            validateField(subject, msgErrorSubj, subjField);
            validateField(message, msgErrorMessage, msgField);

            $.ajax({
                url: baseUrl + "/contact",
                method:"POST",
                data: {
                    'name':name,
                    'email': email,
                    'subject': subject,
                    'message': message,
                    '_token':token
                },
                success: function (data) {
                    console.log(data);
                    console.log(data.message);
                    alert(data.message);
                    $(".errors").html(data.message)
                    if(data.message === "Message is created successfully"){
                        document.getElementById("tbSubjectContact").value = "";
                        document.getElementById("taMessageContact").value = "";
                        $(".errors").html("");
                    }
                },
                error: function (xhr, error,status) {
                    let code = xhr.status;
                    console.log(xhr);
                    console.log(code);
                    printErrors(xhr.responseJSON.errors);
                },
                dataType:"json"
            });


        }
    }


    $('[data-toggle="tooltip"]').tooltip()

    function redirectToPage(pageName) {
        window.location.replace(baseUrl + `${pageName}`)
    }


})
