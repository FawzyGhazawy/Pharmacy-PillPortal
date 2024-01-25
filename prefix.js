const fs = require('fs');
const postcss = require('postcss');
const selectorNamespace = require('postcss-selector-namespace');

fs.readFile('css/bootstrap.css', (err, css) => {
    postcss()
        .use(selectorNamespace({ namespace: '.bs4 ' }))
        .process(css, { from: 'css/bootstrap.css', to: 'css/bootstrap4-prefixed.css' })
        .then(result => {
            fs.writeFile('css/bootstrap4-prefixed.css', result.css, () => true);
            if ( result.map ) {
                fs.writeFile('css/bootstrap4-prefixed.css.map', result.map, () => true);
            }
        });
});
