$(document).ready(function () {
    size_li = $("#myList li").size();
    x=3;
    $('#myList li:lt('+x+')').show();
    $('#loadMore').on('click',function () {
        x= (x+3 <= size_li) ? x+3 : size_li;
        $('#myList li:lt('+x+')').show();
    });
});