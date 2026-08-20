/* https://github.com/tylerecouture/summernote-lists  */

(function (factory) {
  /* global define */
  if (typeof define === "function" && define.amd) {
    // AMD. Register as an anonymous module.
    define(["jquery"], factory);
  } else if (typeof module === "object" && module.exports) {
    // Node/CommonJS
    module.exports = factory(require("jquery"));
  } else {
    // Browser globals
    factory(window.jQuery);
  }
})(function ($) {
  $.extend(true, $.summernote.lang, {
    "en-US": {
      tableStyles: {
        tooltip: "Table style",
        stylesExclusive: ["Basic", "Bordered"],
        stylesInclusive: ["Striped", "Condensed", "Hoverable"]
      }
    }
  });
  $.extend($.summernote.options, {
    tableStyles: {
      // Must keep the same order as in lang.tableStyles.styles*
      stylesExclusive: ["", "table-bordered"],
      stylesInclusive: ["table-striped", "table-condensed", "table-hover"]
    }
  });

  // Extends plugins for emoji plugin.
  $.extend($.summernote.plugins, {
    tableStyles: function (context) {
      var self = this,
        ui = $.summernote.ui,
        options = context.options,
        lang = options.langInfo,
        $editor = context.layoutInfo.editor,
        $editable = context.layoutInfo.editable,
        editable = $editable[0];

      context.memo("button.tableStyles", function () {
        var button = ui.buttonGroup([
          ui.button({
            className: "dropdown-toggle",
            contents: ui.dropdownButtonContents(
              ui.icon(options.icons.magic),
              options
            ),
            tooltip: lang.tableStyles.tooltip,
            data: {
              toggle: "dropdown"
            },
            callback: function ($dropdownBtn) {
              $dropdownBtn.click(function () {
                self.updateTableMenuState($dropdownBtn);
              });
            }
          }),
          ui.dropdownCheck({
            className: "dropdown-table-style",
            checkClassName: options.icons.menuCheck,
            items: self.generateListItems(
              options.tableStyles.stylesExclusive,
              lang.tableStyles.stylesExclusive,
              options.tableStyles.stylesInclusive,
              lang.tableStyles.stylesInclusive
            ),
            callback: function ($dropdown) {
              $dropdown.find("a").each(function () {
                $(this).click(function (e) {
                  self.updateTableStyles(this);
                  e.preventDefault();
                });
              });
            }
          })
        ]);
        return button.render();
      });

      self.updateTableStyles = function (chosenItem) {
        const rng = context.invoke("createRange", $editable);
        const dom = $.summernote.dom;
        if (rng.isCollapsed() && rng.isOnCell()) {
          context.invoke("beforeCommand");
          var table = dom.ancestor(rng.commonAncestor(), dom.isTable);
          self.updateStyles(
            $(table),
            chosenItem,
            options.tableStyles.stylesExclusive
          );
        }
      };

      /* Makes sure the check marks are on the currently applied styles */
      self.updateTableMenuState = function ($dropdownButton) {
        const rng = context.invoke("createRange", $editable);
        const dom = $.summernote.dom;
        if (rng.isCollapsed() && rng.isOnCell()) {
          var $table = $(dom.ancestor(rng.commonAncestor(), dom.isTable));
          var $listItems = $dropdownButton.parent().find(".dropdown-menu a");
          self.updateMenuState(
            $table,
            $listItems,
            options.tableStyles.stylesExclusive
          );
        }
      };

      /* The following functions might be turnkey in other menu lists
            with exclusive and inclusive items that toggle CSS classes. */

      self.updateMenuState = function ($node, $listItems, exclusiveStyles) {
        var hasAnExclusiveStyle = false;
        console.log($listItems)
        $listItems.each(function () {
          var cssClass = $(this).data("value");
          if ($node.hasClass(cssClass)) {
            $(this).addClass("checked");
            if ($.inArray(cssClass, exclusiveStyles) != -1) {
              hasAnExclusiveStyle = true;
            }
          } else {
            $(this).removeClass("checked");
          }
        });

        // if none of the exclusive styles are checked, then check a blank
        if (!hasAnExclusiveStyle) {
          $listItems.filter('[data-value=""]').addClass("checked");
        }
      };

      self.updateStyles = function ($node, chosenItem, exclusiveStyles) {
        var cssClass = $(chosenItem).data("value");
        context.invoke("beforeCommand");
        // Exclusive class: only one can be applied one at a time
        if ($.inArray(cssClass, exclusiveStyles) != -1) {
          $node.removeClass(exclusiveStyles.join(" "));
          $node.addClass(cssClass);
        } else {
          // Inclusive classes: multiple are ok
          $node.toggleClass(cssClass);
        }
        context.invoke("afterCommand");
      };

      self.generateListItems = function (
        exclusiveStyles,
        exclusiveLabels,
        inclusiveStyles,
        inclusiveLabels
      ) {
        var index = 0;
        var list = "";

        for (const style of exclusiveStyles) {
          list += self.getListItem(style, exclusiveLabels[index], true);
          index++;
        }
        list += '<hr style="margin: 5px 0px">';
        index = 0;
        for (const style of inclusiveStyles) {
          list += self.getListItem(style, inclusiveLabels[index], false);
          index++;
        }
        return list;
      };

      self.getListItem = function (
        value,
        label,
        isExclusive,
      ) {
        var item =
          '<li><a href="#" class="' +
          (isExclusive ? "exclusive-item" : "inclusive-item") +
          '" ' +
          'style="display: block;" data-value="' +
          value +
          '">' +
          '<i class="note-icon-menu-check" ' +
          (!isExclusive ? 'style="color:#00ffc0;" ' : "") +
          "></i>" +
          " " +
          label +
          "</a></li>";
        return item;
      };
    }
  });
});
