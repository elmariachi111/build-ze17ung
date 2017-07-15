'use strict';

require('../css/main.scss');

import $ from 'jquery';
global.$ = global.jQuery = $;

import 'tether';
import 'bootstrap';
import 'salvattore';

import _ from 'lodash';

$(() => {
  $('[data-toggle="tooltip"]').tooltip();
});
