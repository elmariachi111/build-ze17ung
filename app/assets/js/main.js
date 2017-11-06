'use strict';

require('../css/main.scss');

import $ from 'jquery';
global.$ = global.jQuery = $;

import 'tether';
import 'bootstrap';
import 'salvattore';
import 'eonasdan-bootstrap-datetimepicker'

import _ from 'lodash';

import InfiniteList from './infinite-list.js';
import {EditorRow, EditableRow} from './editor.js';

$(() => {
    $('[data-toggle="tooltip"]').tooltip();
    $('tr[rel=editable]').each(function() {
        new EditableRow({el: $(this)});
    });
    $('tr[rel=editor]').each(function() {
        new EditorRow({el: $(this)});
    });

    const loadMore = new InfiniteList({el: $('[data-toggle="infinite-list"]') })
});
