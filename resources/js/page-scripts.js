/* Global page scipts */
const PageScripts = (function(){

    function init() {

        // Semantic close button
        $('.message .close').on('click', function() {
            $(this).closest('.message').transition('fade');
        });
        

        $('.show_login_btn').click(function() {
            $('#login_modal').modal('show');
        });
    }

    return {
        init
    }
})();

export default PageScripts;
