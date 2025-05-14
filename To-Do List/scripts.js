$(document).ready(function() {
    $('#todoForm').on('submit',function(e){
        e.preventDefault();
        var task=$('#task').val();
        if(task){
            $.post('todo.php',{task:task},function(response){
                var task=JSON.parse(response);
                if(!task.error){
                    $('#tasks').append('<li data-id="'+task.id+'" class=""><img src="check.png" class="check" alt="check icon">'+task.task+'<img src="x.png" alt="delete icon" class="delete"></li>');
                    $('#task').val('');
                } 
                else{
                    console.error(task.error);
                }
            });
        }
    });

    $('#tasks').on('click','.delete',function() {
        var taskId=$(this).parent().data('id');
        $.post('delete_task.php',{id:taskId},function(response){
            var result=JSON.parse(response);
            if(result.success){
                $('li[data-id="'+taskId+'"]').remove();
            } 
            else{
                console.error(result.error);
            }
        });
    });

    $('#tasks').on('click','.check',function(){
        var taskId=$(this).parent().data('id');
        $.post('toggle_task.php',{id:taskId},function(response){
            var task=JSON.parse(response);
            if(!task.error){
                var li=$('li[data-id="'+task.id+'"]');
                li.toggleClass('completed');
            } 
            else{
                console.error(task.error);
            }
        });
    });

    $('#tasks').on('mouseenter','.check',function(){
        $(this).parent().css('background-color','lightgreen');
        $(this).siblings('.delete').css('visibility','hidden');
    });

    $('#tasks').on('mouseleave','.check',function(){
        $(this).parent().css('background-color','');
        $(this).siblings('.delete').css('visibility','visible');
    });

    $('#tasks').on('mouseenter','.delete',function(){
        $(this).parent().addClass('hover-effect');
        $(this).siblings('.check').css('visibility','hidden');
    });

    $('#tasks').on('mouseleave','.delete',function(){
        $(this).parent().removeClass('hover-effect');
        $(this).siblings('.check').css('visibility','visible');
    });
});
