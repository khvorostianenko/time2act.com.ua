// Если loyout_flag = 0 - загружаем весь контект, если 1 - только контент
// Вставляет текст и распознает html теги
$(document).ready(function(){
   $.post('/admin/news', {loyout_flag:'1'}, function(data){
       $("#news").html(data);
   });
});

// Отображает остальные страницы
function show_other_pages(){
    $("#other_pages").fadeIn(1000);
}

