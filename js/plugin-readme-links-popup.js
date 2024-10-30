jQuery(document).ready(function($) {
    $('.readme-popup-link').click(function(e) {
        e.preventDefault();
        var pluginFile = $(this).data('plugin-file');
        $.post(ajaxurl, {
            action: 'get_readme_content',
            plugin_file: pluginFile
        }, function(response) {
            var readmePopup = window.open('', '_blank', 'width=800,height=800');
            readmePopup.document.write('<html><head><title>Readme</title><style>body { font-family: sans-serif; }</style></head><body><div style="padding:20px;">' + response + '</div></body></html>');
        });
    });
});
