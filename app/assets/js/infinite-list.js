import $ from 'jquery';
import 'salvattore';

import {Card} from './card.js';

export default class InfiniteList extends Backbone.View {
  events() {
    return {'click a.loadmore': "loadmore" }
  }

  initialize() {
    this.url = this.$el.data('url');
    this.lastCardId = this.$el.data('lastId');
    this.$loadMore = this.$('a.loadmore');
    this.initCards(this.$('.card:not(.btn)'));
  }

  loadmore() {
    this.$loadMore.detach();
    $.get(this.url, {before: this.lastCardId}).done(this.loaded.bind(this));
    return false;
  }
  initCards($cards) {
    $cards.each(function() {
      new Card({el: $(this)});
    });
  }

  loaded(res, status, txt) {
    const $moreCards = $(res);
    this.lastCardId = $moreCards.last().data('id');
    salvattore.appendElements(this.$el[0], $moreCards);
    salvattore.appendElements(this.$el[0], this.$loadMore);
    this.initCards($moreCards);
  }
}
