# summernote-table-headers
A [Summernote](http://summernote.org/) plugin that adds a button to the table popover allowing the user to toggle the first row as a table header.

### How it works
The plugin creates a `<thead>` element at the top of the table, and moves the top `<tr>` into the header.  It then swaps each of the `<td>` cells for `<th>` header cells.  Toggle the header off reversese this.
  
When the summernote table popover is used to create a new column, summernote creates `<td>` cells within the header.  The pluging detects these changes to the table and converts them to propper `<th>` header cells.
  
### Usage

1. Include `summernote-table-headers.js`
2. Customize the Summernote table popover to include `tableHeaders`
````
$(document).ready(function() {
  $('#summernote').summernote({
    popover: {
      table: [
        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
        ['custom', ['tableHeaders']]
      ],
    },
  });
});
````

### Working Example

https://rawgit.com/tylerecouture/summernote-table-headers/master/Example/example.html

### To do
* Add vertical headers
