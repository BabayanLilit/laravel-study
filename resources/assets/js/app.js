
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(function () {
    var $body = $('body');

    $body
        .on('click', '.department-list .delete-button, .employee-list .delete-button', function (e) {
            var $this = $(this),
                $form = $this.closest('form');

            $.ajax({
                url: $form.attr('action'),
                type: 'post',
                dataType: 'JSON',
                data: $form.serialize(),
                success: function (result) {
                    alert(result.message);
                    if (result.success) {
                        $this.closest('tr').remove();
                    }
                }
            });
        })
        .on('submit', '.department-form-container form, .employee-form-container form', function (e) {
            e.preventDefault();
            var $this = $(this),
                $buttonSave = $this.find('btn-save');
            $buttonSave.hide();
            $.ajax({
                url: $this.attr('action'),
                type: 'post',
                dataType : 'JSON',
                data : $this.serialize(),
                success: function(result) {
                    $('.form-group').removeClass('has-error');

                    if (result.success) {
                        alert(result.message);
                        if (result.redirect) {
                            location.href = result.redirect;
                        }
                    } else {
                        var $input;
                        for (var key in result.errors) {
                            console.log(key);
                            $input = $this.find('input[name="' + key + '"]');
                            if (!$input.length) {
                                $input = $this.find('input[name="' + key + '[]"]');
                            }
                            if ($input.length) {
                                $input.closest('.form-group').addClass('has-error');
                            }
                        }

                        $buttonSave.show();

                        if (result.message) {
                            alert(result.message);
                        }
                    }
                }
            });
        })
});