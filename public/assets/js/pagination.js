$(document).ready(function(){
    $(".page-link").click(showMore);


})
var path = window.location.href;
const url = window.location.pathname;
console.log(url)
console.log(path)

function showMore(e){
    e.preventDefault();
    // console.log('showMore')
    let page = $(this).data("page");
    var dateFrom = $("#dateFrom").val();
    var dateTo = $("#dateTo").val();
    console.log("page"+page)
    if(url.indexOf("/admin") !== -1 || url.indexOf("/admin/") !== -1){
        getActivities(page,dateFrom,dateTo)
    }
    if(url.indexOf("/admin/messages") !== -1 ){
        getAllMessages(page);
    }
    // console.log("dateFrom"+dateFrom)
    // console.log("dateTo"+dateTo)




}
function printPagination(total,current){
    let html = "";
    for(let i = 1; i <= total; i++){
        if(i !== current){
            html += `<li class="page-item"><a class="page-link" id="link${i}" data-page="${i}" href="#">${i}</a></li>`;
        }else{
            html += `<li class="page-item active"><a class="page-link" id = "link${i}" data-page="${i}" href="#">${i}</a></li>`;
        }
    }
    // alert(html)
    $("#paginacija").html(html);
    $(".page-link").click(showMore);
}
function changeActiveLink(current){
    $('.page-item').removeClass('active');
    $('#link' + current).parent().addClass('active');
}
