/**
 *
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2016 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 * @version    1.0.0
 */
$(document).ready(function() {

    $('form[name=delete]').on('submit', function() {
        return confirm('Are you sure?');
    });

    setTimeout(function() {
          $('.alert.autohide').hide("slow");
    }, 5000);

});
