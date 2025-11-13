/*
 * Control like L.Control.Layers, but showing layers in a tree.
 * Do not forget to include the css file.
 */

(function(L) {
    if (typeof L === 'undefined') {
        throw new Error('Leaflet must be included first');
    }

    /*
     * L.Control.Layers.Tree extends L.Control.Layers because it reuses
     * most of its functionality. Only the HTML creation is different.
     */
    L.Control.Layers.Tree = L.Control.Layers.extend({
        options: {
            closedSymbol: '+',
            openedSymbol: '&minus;',
            spaceSymbol: ' ',
            selectorBack: false,
            namedToggle: false,
            collapseAll: '',
            expandAll: '',
            labelIsSelector: 'both',
        },

        // Class names are error prone texts, so write them once here
        _initClassesNames: function() {
            this.cls = {
                children: 'leaflet-layerstree-children',
                childrenNopad: 'leaflet-layerstree-children-nopad',
                hide: 'leaflet-layerstree-hide',
                closed: 'leaflet-layerstree-closed',
                opened: 'leaflet-layerstree-opened',
                space: 'leaflet-layerstree-header-space',
                pointer: 'leaflet-layerstree-header-pointer',
                header: 'leaflet-layerstree-header',
                neverShow: 'leaflet-layerstree-nevershow',
                node: 'leaflet-layerstree-node',
                name: 'leaflet-layerstree-header-name',
                label: 'leaflet-layerstree-header-label',
                selAllCheckbox: 'leaflet-layerstree-sel-all-checkbox',
            };
        },

        initialize: function(baseTree, overlaysTree, options) {
            this._scrollTop = 0;
            this._initClassesNames();
            this._baseTree = null;
            this._overlaysTree = null;
            L.Util.setOptions(this, options);
            L.Control.Layers.prototype.initialize.call(this, null, null, options);
            this._setTrees(baseTree, overlaysTree);
        },

        setBaseTree: function(tree) {
            return this._setTrees(tree);
        },

        setOverlayTree: function(tree) {
            return this._setTrees(undefined, tree);
        },

        addBaseLayer: function(_layer, _name) {
            throw 'addBaseLayer is disabled';
        },

        addOverlay: function(_layer, _name) {
            throw 'addOverlay is disabled';
        },

        removeLayer: function(_layer) {
            throw 'removeLayer is disabled';
        },

        collapse: function() {
            this._scrollTop = this._sect().scrollTop;
            return L.Control.Layers.prototype.collapse.call(this);
        },

        expand: function() {
            L.Control.Layers.prototype.expand.call(this);
            this._sect().scrollTop = this._scrollTop;
        },

        onAdd: function(map) {
            function changeName(layer) {
                if (layer._layersTreeName) {
                    toggle.innerHTML = layer._layersTreeName;
                }
            }

            var ret = L.Control.Layers.prototype.onAdd.call(this, map);
            if (this.options.namedToggle) {
                var toggle = this._container.getElementsByClassName('leaflet-control-layers-toggle')[0];
                L.DomUtil.addClass(toggle, 'leaflet-layerstree-named-toggle');
                // Start with this value...
                map.eachLayer(function(layer) {changeName(layer);});
                // ... and change it whenever the baselayer is changed.
                map.on('baselayerchange', function(e) {changeName(e.layer);}, this);
            }
            return ret;
        },

        // Expands the whole tree (base other overlays)
        expandTree: function(overlay) {
            var container = overlay ? this._overlaysList : this._baseLayersList;
            if (container) {
                this._applyOnTree(container, false);
            }
            return this._localExpand();
        },

        // Collapses the whole tree (base other overlays)
        collapseTree: function(overlay) {
            var container = overlay ? this._overlaysList : this._baseLayersList;
            if (container) {
                this._applyOnTree(container, true);
            }
            return this._localExpand();
        },

        // Expands the tree, only to show the selected inputs
        expandSelected: function(overlay) {
            function iter(el) {
                // Function to iterate the whole DOM upwards
                var p = el.parentElement;
                if (p) {
                    if (L.DomUtil.hasClass(p, that.cls.children) &&
                        !L.DomUtil.hasClass(el, that.cls.childrenNopad)) {
                        L.DomUtil.removeClass(p, hide);
                    }

                    if (L.DomUtil.hasClass(p, that.cls.node)) {
                        var h = p.getElementsByClassName(that.cls.header)[0];
                        that._applyOnTree(h, false);
                    }
                    iter(p);
                }
            }

            var that = this;
            var container = overlay ? this._overlaysList : this._baseLayersList;
            if (!container) return this;
            var hide = this.cls.hide;
            var inputs = this._layerControlInputs || container.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                // Loop over every (valid) input.
                var input = inputs[i];
                if (this._getLayer && !!this._getLayer(input.layerId).overlay != !!overlay) continue;
                if (input.checked) {
                    // Get out of the header,
                    // to not open the possible (but rare) children
                    iter(input.parentElement.parentElement.parentElement.parentElement);
                }
            }
            return this._localExpand();
        },

        // "private" methods, not exposed in the API
        _sect: function() {
            // to keep compatibility after 1.3 https://github.com/Leaflet/Leaflet/pull/6380
            return this._section || this._form;
        },

        _setTrees: function(base, overlays) {
            var id = 0; // to keep unique id
            function iterate(tree, output, overlays) {
                if (tree && tree.layer) {
                    if (!overlays) {
                        tree.layer._layersTreeName = tree.name || tree.label;
                    }
                    output[id++] = tree.layer;
                }
                if (tree && tree.children && tree.children.length) {
                    tree.children.forEach(function(child) {
                        iterate(child, output, overlays);
                    });
                }
                return output;
            }

            // We accept arrays, but convert into an object with children
            function forArrays(input) {
                if (Array.isArray(input)) {
                    return {noShow: true, children: input};
                } else {
                    return input;
                }
            }

            // Clean everything, and start again.
            if (this._layerControlInputs) {
                this._layerControlInputs = [];
            }
            for (var i = 0; i < this._layers.length; ++i) {
                this._layers[i].layer.off('add remove', this._onLayerChange, this);
            }
            this._layers = [];

            if (base !== undefined) this._baseTree = forArrays(base);
            if (overlays !== undefined) this._overlaysTree = forArrays(overlays);

            var bflat = iterate(this._baseTree, {});
            for (var j in bflat) {
                this._addLayer(bflat[j], j);
            }

            var oflat = iterate(this._overlaysTree, {}, true);
            for (var k in oflat) {
                this._addLayer(oflat[k], k, true);
            }
            return (this._map) ? this._update() : this;
        },

        // Used to update the vertical scrollbar
        _localExpand: function() {
            if (this._map && L.DomUtil.hasClass(this._container, 'leaflet-control-layers-expanded')) {
                var top = this._sect().scrollTop;
                this.expand();
                this._sect().scrollTop = top; // to keep the scroll location
                this._scrollTop = top;
            }
            return this;
        },

        // collapses or expands the tree in the container.
        _applyOnTree: function(container, collapse) {
            var iters = [
                {cls: this.cls.children, hide: collapse},
                {cls: this.cls.opened, hide: collapse},
                {cls: this.cls.closed, hide: !collapse},
            ];
            iters.forEach(function(it) {
                var els = container.getElementsByClassName(it.cls);
                for (var i = 0; i < els.length; i++) {
                    var el = els[i];
                    if (L.DomUtil.hasClass(el, this.cls.childrenNopad)) {
                        // do nothing
                    } else if (it.hide) {
                        L.DomUtil.addClass(el, this.cls.hide);
                    } else {
                        L.DomUtil.removeClass(el, this.cls.hide);
                    }
                }
            }, this);
        },

        // it is called in the original _update, and shouldn't do anything.
        _addItem: function(_obj) {
        },

        // overwrite _update function in Control.Layers
        _update: function() {
            if (!this._container) { return this; }
            L.Control.Layers.prototype._update.call(this);
            this._addTreeLayout(this._baseTree, false);
            this._addTreeLayout(this._overlaysTree, true);
            return this._localExpand();
        },

        // Create the DOM objects for the tree
        _addTreeLayout: function(tree, overlay) {
            if (!tree) return;
            var container = overlay ? this._overlaysList : this._baseLayersList;
            this._expandCollapseAll(overlay, this.options.collapseAll, this.collapseTree);
            this._expandCollapseAll(overlay, this.options.expandAll, this.expandTree);
            this._iterateTreeLayout(tree, container, overlay, [], tree.noShow);
            if (this._checkDisabledLayers) {
                // to keep compatibility
                this._checkDisabledLayers();
            }
        },

        // Create the "Collapse all" or expand, if needed.
        _expandCollapseAll: function(overlay, text, fn, ctx) {
            var container = overlay ? this._overlaysList : this._baseLayersList;
            ctx = ctx ? ctx : this;
            if (text) {
                var o = document.createElement('div');
                o.className = 'leaflet-layerstree-expand-collapse';
                container.appendChild(o);
                o.innerHTML = text;
                o.tabIndex = 0;
                L.DomEvent.on(o, 'click keydown', function(e) {
                    if (e.type !== 'keydown' || e.keyCode === 32) {
                        o.blur();
                        fn.call(ctx, overlay);
                        this._localExpand();
                    }
                }, this);
            }
        },

        // recursive function to create the DOM children
        _iterateTreeLayout: function(tree, container, overlay, selAllNodes, noShow) {
            if (!tree) return;
            function creator(type, cls, append, innerHTML) {
                var obj = L.DomUtil.create(type, cls, append);
                if (innerHTML) obj.innerHTML = innerHTML;
                return obj;
            }

            // create the header with it fields
            var header = creator('div', this.cls.header, container);
            var sel = creator('span');
            var entry = creator('span');
            var closed = creator('span', this.cls.closed, sel, this.options.closedSymbol);
            var opened = creator('span', this.cls.opened, sel, this.options.openedSymbol);
            var space = creator('span', this.cls.space, null, this.options.spaceSymbol);
            if (this.options.selectorBack) {
                sel.insertBefore(space, closed);
                header.appendChild(entry);
                header.appendChild(sel);
            } else {
                sel.appendChild(space);
                header.appendChild(sel);
                header.appendChild(entry);
            }

            function updateSelAllCheckbox(ancestor) {
                var selector = ancestor.querySelector('input[type=checkbox]');
                var selectedAll = true;
                var selectedNone = true;
                var inputs = ancestor.querySelectorAll('input[type=checkbox]');
                [].forEach.call(inputs, function(inp) { // to work in node for tests
                    if (inp === selector) {
                        // ignore
                    } else if (inp.indeterminate) {
                        selectedAll = false;
                        selectedNone = false;
                    } else if (inp.checked) {
                        selectedNone = false;
                    } else if (!inp.checked) {
                        selectedAll = false;
                    }
                });
                if (selectedAll) {
                    selector.indeterminate = false;
                    selector.checked = true;
                } else if (selectedNone) {
                    selector.indeterminate = false;
                    selector.checked = false;
                } else {
                    selector.indeterminate = true;
                    selector.checked = false;
                }
            }

            function manageSelectorsAll(input, ctx) {
                selAllNodes.forEach(function(ancestor) {
                    L.DomEvent.on(input, 'click', function(_ev) {
                        updateSelAllCheckbox(ancestor);
                    }, ctx);
                }, ctx);
            }

            var selAll;
            if (tree.selectAllCheckbox) {
                selAll = this._createCheckboxElement(false);
                selAll.className += ' ' + this.cls.selAllCheckbox;
            }

            var hide = this.cls.hide; // To toggle state
            // create the children group, with the header event click
            if (tree.children) {
                var children = creator('div', this.cls.children, container);
                var sensible = tree.layer ? sel : header;
                L.DomUtil.addClass(sensible, this.cls.pointer);
                sensible.tabIndex = 0;
                L.DomEvent.on(sensible, 'click keydown', function(e) {
                    // leaflet internal flag to prevent click propagation and collapsing tree on mobile browsers
                    if (this._preventClick) {
                        return;
                    }
                    if (e.type === 'keydown' && e.keyCode !== 32) {
                        return;
                    }
                    sensible.blur();

                    if (L.DomUtil.hasClass(opened, hide)) {
                        // it is not opened, so open it
                        L.DomUtil.addClass(closed, hide);
                        L.DomUtil.removeClass(opened, hide);
                        L.DomUtil.removeClass(children, hide);
                    } else {
                        // close it
                        L.DomUtil.removeClass(closed, hide);
                        L.DomUtil.addClass(opened, hide);
                        L.DomUtil.addClass(children, hide);
                    }
                    this._localExpand();
                }, this);
                if (selAll) {
                    selAllNodes.splice(0, 0, container);
                }
                tree.children.forEach(function(child) {
                    var node = creator('div', this.cls.node, children);
                    this._iterateTreeLayout(child, node, overlay, selAllNodes);
                }, this);
                if (selAll) {
                    selAllNodes.splice(0, 1);
                }
            } else {
                // no children, so the selector makes no sense.
                L.DomUtil.addClass(sel, this.cls.neverShow);
            }

            // make (or not) the label clickable to toggle the layer
            var labelType;
            if (tree.layer) {
                if ((this.options.labelIsSelector === 'both') || // if option is set to both
                    (overlay && this.options.labelIsSelector === 'overlay') || // if an overlay layer and options is set to overlay
                    (!overlay && this.options.labelIsSelector === 'base')) { // if a base layer and option is set to base
                    labelType = 'label';
                } else { // if option is set to something else
                    labelType = 'span';
                }
            } else {
                labelType = 'span';
            }
            // create the input and label
            var label = creator(labelType, this.cls.label, entry);
            if (tree.layer) {
                // now create the element like in _addItem
                var checked = this._map.hasLayer(tree.layer);
                var input;
                var radioGroup = overlay ? tree.radioGroup : 'leaflet-base-layers_' + L.Util.stamp(this);
                if (radioGroup) {
                    input = this._createRadioElement(radioGroup, checked);
                } else {
                    input = this._createCheckboxElement(checked);
                    manageSelectorsAll(input, this);
                }
                if (this._layerControlInputs) {
                    // to keep compatibility with 1.0.3
                    this._layerControlInputs.push(input);
                }
                input.layerId = L.Util.stamp(tree.layer);
                L.DomEvent.on(input, 'click', this._onInputClick, this);
                label.appendChild(input);
            }

            function isText(variable) {
                return (typeof variable === 'string' || variable instanceof String);
            }

            function isFunction(functionToCheck) {
                return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
            }

            function selectAllCheckboxes(select, ctx) {
                var inputs = container.getElementsByTagName('input');
                for (var i = 0; i < inputs.length; i++) {
                    var input = inputs[i];
                    if (input.type !== 'checkbox') continue;
                    input.checked = select;
                    input.indeterminate = false;
                }
                ctx._onInputClick();
            }
            if (tree.selectAllCheckbox) {
                // selAll is already created
                label.appendChild(selAll);
                if (isText(tree.selectAllCheckbox)) {
                    selAll.title = tree.selectAllCheckbox;
                }
                L.DomEvent.on(selAll, 'click', function(ev) {
                    ev.stopPropagation();
                    selectAllCheckboxes(selAll.checked, this);
                }, this);
                updateSelAllCheckbox(container);
                manageSelectorsAll(selAll, this);
            }

            creator('span', this.cls.name, label, tree.label);

            // hide the button which doesn't fit the collapsed state, then hide children conditionally
            L.DomUtil.addClass(tree.collapsed ? opened : closed, hide);
            tree.collapsed && children && L.DomUtil.addClass(children, hide);

            if (noShow) {
                L.DomUtil.addClass(header, this.cls.neverShow);
                L.DomUtil.addClass(children, this.cls.childrenNopad);
            }

            var eventeds = tree.eventedClasses;
            if (!(eventeds instanceof Array)) {
                eventeds = [eventeds];
            }

            for (var e = 0; e < eventeds.length; e++) {
                var evented = eventeds[e];
                if (evented && evented.className) {
                    var obj = container.querySelector('.' + evented.className);
                    if (obj) {
                        L.DomEvent.on(obj, evented.event || 'click', (function(selectAll) {
                            return function(ev) {
                                ev.stopPropagation();
                                var select = isFunction(selectAll) ? selectAll(ev, container, tree, this._map) : selectAll;
                                if (select !== undefined && select !== null) {
                                    selectAllCheckboxes(select, this);
                                }
                            };
                        })(evented.selectAll), this);
                    }
                }
            }
        },

        _createCheckboxElement: function(checked) {
            var input = document.createElement('input');
            input.type = 'checkbox';
            input.className = 'leaflet-control-layers-selector';
            input.defaultChecked = checked;
            return input;
        },

    });

    L.control.layers.tree = function(base, overlays, options) {
        return new L.Control.Layers.Tree(base, overlays, options);
    };

})(L);