
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(function () {
    console.log('dsadsad');
    var $body = $('body');

    $body
        .on('submit', '.employee-form-container form', function (e) {
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
                    console.log(result.errors);
                    console.log(result);
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
        });
});