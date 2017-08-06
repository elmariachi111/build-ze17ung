'use strict';

require('../css/main.scss');

import $ from 'jquery';
global.$ = global.jQuery = $;

import 'tether';
import 'bootstrap';
import 'salvattore';

import _ from 'lodash';
import InfiniteList from './infinite-list.js';

$(() => {
  $('[data-toggle="tooltip"]').tooltip();
  const loadMore = new InfiniteList({el: $('[data-toggle="infinite-list"]') })
});
