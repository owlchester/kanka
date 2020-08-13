# summernote-table-styles
A [Summernote](https://summernote.org/) plugin that adds a button to the table popover allowing the user to apply [Bootstrap table styles](https://getbootstrap.com/docs/3.3/css/#tables).

There are two types of styles, exclusive and inclusive. Only one exclusive style may be chosen at a time, whereas multiple inclusive styles may be chosen.  Currently applied styles are indicated with check marks.

**Exclusive Styles**
* Basic (Default Bootstrap table)
* Bordered

**Inclusive Styles**
* Striped
* Condensed
* Hoverable

### Usage

1. Add `summernote-table-styles.js` to your project
2. Customize the Summernote table popover to include `tableStyles`
````
$(document).ready(function() {
  $('#summernote').summernote({
    popover: {
      table: [
        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
        ['custom', ['tableStyles']]
      ],
    },
  });
});
````

### Working Example

https://rawgit.com/tylerecouture/summernote-table-styles/master/Example/example.html
