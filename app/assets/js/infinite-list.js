import $ from 'jquery';
import 'salvattore';

export default class InfiniteList {

  constructor($el) {
    this.$el = $el;
    this.activateTrigger();
  }

  activateTrigger() {
    this.$trigger = this.$el.find('a.loadmore');
    this.$trigger.on("click",this.loadmore.bind(this))
  }

  loadmore() {
    const url = this.$trigger.attr('href');
    this.$trigger.detach();

    $.get(url).done(this.loaded.bind(this));
    return false;
  }

  loaded(res, status, txt) {
    const $moreCards = $(res);
    salvattore.appendElements(this.$el[0], $moreCards);
    this.activateTrigger();
  }
}