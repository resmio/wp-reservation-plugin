(function() {
    tinymce.PluginManager.add('resmio_custom_mce_button', function(editor, url) {
        editor.addButton('resmio_custom_mce_button', {
            type: 'menubutton',
            text: 'resmio',
            icon: false,
            menu: [
                {text: 'resmio Button', onclick: function() {editor.insertContent('[resmio-button]');}},
                {text: 'resmio Widget', onclick: function() {editor.insertContent('[resmio-widget]');}}
            ]
        });
    });
})();