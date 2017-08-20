import Backbone from 'backbone'
import _ from 'lodash';

const Tag = Backbone.Model.extend({
    idAttribute: 'slug'
});

const Tags = Backbone.Collection.extend({
    model: Tag
})

class TagView extends Backbone.View {

    events() {
        return {
            'click .fa-remove': "removeTag"
        };
    }
    initialize() {
        const $tags = this.$('.badge');
        const tags = $tags.map(function() {
            return new Tag({slug: $(this).find('.slug').text() });
        }).toArray();

        this.collection = new Tags(tags);
        this.collection.on('update', this.render.bind(this));
    }

    render() {
        let markup = this.collection.map((tag) => {
            const slug = tag.get('slug');
            return `<span class="badge badge-pill badge-default">
                        <span class="slug">${slug}</span>
                        <i class="fa fa-remove"></i>
                    </span>`;
        }).join(' ');
        this.$el.html(markup);
    }

    removeTag(evt) {
        const slug = $(evt.currentTarget).parent().find('.slug').text();
        const tag = this.collection.get(slug);
        tag.destroy();
    }
}

export class Card extends Backbone.View {
    events() {
        return {
            "submit [data-toggle='tag-form']": "submitTag"
        }
    }

    initialize() {
        const tagView = new TagView({el: this.$('.tags')});
        this.$tagForm = this.$("[data-toggle='tag-form']");

        this.tags = tagView.collection;
        this.tags.url = this.$tagForm.attr('action');
    }

    submitTag() {
        let $slug = this.$tagForm.find('input[name=slug]');
        this.tags.create({slug: $slug.val()});
        $slug.val('');
        return false;
    }

}