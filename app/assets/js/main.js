'use strict';

require('../css/main.scss');

import $ from 'jquery';
global.$ = global.jQuery = $;

import 'tether';
import 'bootstrap';

import _ from 'lodash';

$(() => {
  $('h1').html('kuckuck');
  $('[data-toggle="tooltip"]').tooltip();
  console.log(_.isString("hello"));
});
