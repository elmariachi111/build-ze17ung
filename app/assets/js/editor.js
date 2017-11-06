import * as Backbone from 'backbone';
import {datePickerParams} from './datepicker.js';

export class EditorRow extends Backbone.View {
    events() {
        return {
            'click button[type="submit"]': "submit"
        }
    }

    initialize() {
        this.$('[rel=datetimepicker]').datetimepicker(datePickerParams);
    }

    submit() {
        const data = this.$('form').serialize();
        $.post(this.$('form').attr('action'), data, (res) => {
           const $res = $(res);
           new EditableRow({el: $res});
           $res.insertAfter(this.$el);
           this.remove();
        });
        return false;
    }
}

export class EditableRow extends Backbone.View {

    events() {
        return {
            "click a[data-toggle=edit]": 'editor'
        }
    }

    initialize() {
        this.cols = this.$('td').length;
    }

    editor() {
        const $trigger = this.$('a[data-toggle=edit]');
        const href = $trigger.attr('href');

        $.get(href, (res) => {
            const $form = $('<tr><td colspan="'+this.cols+'">'+res+'</td></tr>');
            $form.insertAfter(this.$el);
            new EditorRow({el: $form});

            this.remove();
        })

        return false;
    }
}