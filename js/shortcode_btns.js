(function() {
    tinymce.PluginManager.add('custom_mce_button', function(editor, url) {
        editor.addButton('custom_mce_button', {
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