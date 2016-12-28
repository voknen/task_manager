function registerFormAction() {
    $('body').on('submit', '#register-form', function(){
        var data = $(this).serializeArray();
        var formUrl = $(this).attr('action');

        $.ajax({
            url: formUrl,
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend: function () {
                $('p.error-input').remove();
                $('p.success').remove();
            },
            success: function (response) {
                    $('#register-form')[0].reset();
                    $('#register-form').before('<p class="success">' + response.success + '</p>')
            },
            error: function (xhr) {
                var json_response = JSON.parse(xhr.responseText);
                $.each(json_response, function(key, value){
                    $.each(value, function(sub_key, sub_value){
                        $('input[name="' + key + '"]').after('<p class="error-input">' + sub_value + '</p>');
                    });
                });
            }
        });
        
        return false;
    });
}

function loginFormAction() {
    $('body').on('submit', '#login-form', function(){
        var data = $(this).serializeArray();
        var formUrl = $(this).attr('action');

        $.ajax({
            url: formUrl,
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend: function () {
                $('p.error-input').remove();
                $('p.success').remove();
            },
            success: function (response) {
                    window.location.href = "/task_manager/views/index.php";
                    document.cookie = "id=" + response.user_id + "; path=/";
                    document.cookie = "is_logged=" + response.is_logged + "; path=/";
            },
            error: function (xhr) {
                var json_response = JSON.parse(xhr.responseText);
                $.each(json_response, function(key, value){
                    $.each(value, function(sub_key, sub_value){
                        $('input[name="' + key + '"]').after('<p class="error-input">' + sub_value + '</p>');
                    });
                });
            }
        });
        
        return false;
    });
}

function addTaskAction() {
    $('body').on('submit', '#add-task', function(){
        var data = $(this).serializeArray();
        var formUrl = $(this).attr('action');

        $.ajax({
            url: formUrl,
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend: function () {
                $('p.error-input').remove();
                $('p.success').remove();
            },
            success: function (response) {
                $('#add-task')[0].reset();
                $('#add-task').after('<p class="success">' + response.success + '</p>');
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                return false;
            },
            error: function (xhr) {
                var json_response = JSON.parse(xhr.responseText);
                $.each(json_response, function(key, value){
                    $.each(value, function(sub_key, sub_value){
                        if (key == 'info') {
                           $('textarea[name="' + key + '"]').after('<p class="error-input">' + sub_value + '</p>'); 
                        }
                        $('input[name="' + key + '"]').after('<p class="error-input">' + sub_value + '</p>');
                    });
                });
            }
        });
        
        return false;
    });
}

function editTaskAction() {
    $('body').on('submit', '#edit-task', function(){
        var data = $(this).serializeArray();
        var formUrl = $(this).attr('action');
        $.ajax({
            url: formUrl,
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend: function () {
                $('p.error-input').remove();
                $('p.success').remove();
            },
            success: function (response) {
                $('#edit-task').after('<p class="success">' + response.success + '</p>');
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                return false;
            },
            error: function (xhr) {
                var json_response = JSON.parse(xhr.responseText);
                $.each(json_response, function(key, value){
                    $.each(value, function(sub_key, sub_value){
                        if (key == 'info') {
                           $('textarea[name="' + key + '"]').after('<p class="error-input">' + sub_value + '</p>'); 
                        }
                        $('input[name="' + key + '"]').after('<p class="error-input">' + sub_value + '</p>');
                    });
                });
            }
        });
        
        return false;
    });
}

function completeTaskAction() {
    $('body').on('click', '.complete-task', function () {
        var data = {
            'id' : $(this).data('task-id'),
            'action' : 'complete_task_action'
        };   

        $.ajax({
            url: "../library/ajax.php",
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (response) {
                window.location.href = "/task_manager/views/index.php";
            },
            error: function (xhr) {
                
            }
        });
        
        return false;     
    });
}

$(document).ready(function(){
    $(".main_menu_user").load("menu_user.html");
    $('#deadline').datepicker({ dateFormat: 'yy-mm-dd', minDate: 0 });
    registerFormAction();
    loginFormAction();
    addTaskAction();
    editTaskAction();
    completeTaskAction();
    
});