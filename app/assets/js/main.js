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

$(() => {
  $('[data-toggle="tooltip"]').tooltip();
  $('[rel=datetimepicker]').datetimepicker({
      locale: 'de',
      icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-arrow-up",
          down: "fa fa-arrow-down",
          previous: "fa fa-arrow-left",
          next: "fa fa-arrow-right"
      }
  });
  const loadMore = new InfiniteList({el: $('[data-toggle="infinite-list"]') })
});
