jQuery(window).on('elementor:init', function() {

    var postSelectControl = elementor.modules.controls.BaseData.extend({ 

        checkSearch: false,

        getResult: function() {

            const _this = this;

            var ids = this.getControlValue();

            if ( ! ids || ids.length == 0 ) return;

            if ( ! _.isArray( ids ) ) ids = [ids];

            jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    action: _this.model.get('get_data'),
                    post_type: _this.model.get('post_type'),
                    ids: ids
                },
                dataType: 'json',
                success: function(data){
                    
                    _this.checkSearch = true;
                    
                    _this.model.set('options', data);
                    _this.render();
                }
            });
        },

        onReady: function() {

            // this.control_select = this.$el.find('.post-select');
            // this.save_input = this.$el.find('.post-select-save-value');

            var _this = this;

            this.ui.select.select2({
                allowClear: true,
                minimumInputLength: 3,
                placeholder: 'Search',
                ajax: {
                    url: ajaxurl,
                    data: function( params ) {

                        return {
                            key: params.term,
                            action: _this.model.get('search'),
                            post_type: _this.model.get('post_type')
                        } 
                    },
                    dataType: 'json',
                    method: 'post',
                    delay: 200,
                    processResults: function(data){

                        return {
                            results: data
                        }
                    }
                },
                cache: true
            });

            if ( this.checkSearch == false ) this.getResult();

        },
        onBeforeDestroy: function() {
            if (this.ui.select.data('select2')) {
                this.ui.select.select2('destroy');
            }

            this.$el.remove();

        }

    });

    elementor.addControlView( 'kalles_post_select', postSelectControl );
})
