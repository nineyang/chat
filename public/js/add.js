/**
 * Created by sf on 2017/9/20.
 */

$('input:radio').change(function () {
    if ($(this).val() == 1) {
        $('#cipherDiv').removeClass('hidden').addClass('show');
    } else {
        $('#cipherDiv').addClass('hidden');
    }
});