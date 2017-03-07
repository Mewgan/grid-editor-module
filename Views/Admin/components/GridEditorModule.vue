<style>
    .edit-grid-editor .module-title{
        padding: 10px;
        background: #f2f2f2;
    }
    .content {
        overflow: visible;
        position: relative;
        width: auto;
        margin-left: 0;
        padding: inherit;
    }
   .mce-tinymce, .mce-widget, .mce-container{
        z-index: 900200 !important;
   }
   .edit-grid-editor .media-library{
        z-index: 900300 !important;
   }

</style>

<template>
    <div class="edit-grid-editor">
        <form class="form">
            <div v-show="auth.status.level < 4">
                <h5 class="module-title">Information :</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="content.name" :id="'content-name-' + line">
                            <label :for="'content-name-' + line">Nom *</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="content.block"
                                   :id="'content-block-' + line">
                            <label :for="'content-block-' + line">Bloc *</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" :value="content.module.category.title" readonly
                                   :id="'content-module-' + line">
                            <label :for="'content-module-' + line">Module</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" :value="content.module.name" readonly
                                   :id="'content-extension-' + line">
                            <label :for="'content-extension-' + line">Extension</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" v-model="content_data.class" :id="'content-class-' + line">
                    <label :for="'content-class-' + line">Class</label>
                </div>
            </div>
            <div>
                <div :id="'grid-editor-' + line"></div>
            </div>
        </form>

        <media :id="'grid-editor-media-' + line" :launch_media="launch_media" @updateTarget="targetUpdate"
               :button="false" :dir="'/public/media/sites/'+ website.id + '/'" :accepted_file_type="file_type"></media>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            <button type="button" @click="updateContent" class="btn btn-primary" data-dismiss="modal">Enregistrer
            </button>
        </div>

        <div class="modal fade" :id="'toolGridEditor-' + line" tabindex="-1" role="dialog"
             aria-labelledby="simpleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-xlg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click="closeTools" aria-hidden="true">×</button>
                        <h4 class="modal-title" :id="'simpltoolGridEditor-' + line">Outils</h4>
                    </div>
                    <div class="modal-body">
                        <colorpicker :id="line" @updateColorpicker="updateColorpicker"></colorpicker>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" @click="closeTools">Fermer</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

    </div>
</template>

<script type="text/babel">

    import '@modules/GridEditor/Resources/public/css/grideditor/grideditor.css'
    import '@modules/GridEditor/Resources/public/css/grideditor/grideditor-font-awesome.css'

    import '@modules/GridEditor/Resources/public/js/jquery-ui.min'
    import '@modules/GridEditor/Resources/public/js/tinymce/jquery.tinymce.min'
    import '@modules/GridEditor/Resources/public/js/grideditor/jquery.grideditor'

    import Media from '@front/components/Helper/Media.vue'
    import Colorpicker from '@front/components/Helper/Colorpicker.vue'
    import {mapGetters, mapActions} from 'vuex'

    export default{
        name: 'grid-editor',
        components: {Media, Colorpicker},
        props: {
            line: {
                default: 'default'
            },
            content: {
                type: Object,
                required: true
            },
            page: {
                default: null
            },
            website: {
                required: true
            }
        },
        data(){
            return {
                website_id: this.$route.params.website_id,
                content_data: {
                    class: '',
                    content: ''
                },
                file_type: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'],
                grid_el: null,
                launch_media: false,
                media_update_type: 'normal',
                media_target_id: null
            }
        },
        watch: {
            'content_data': {
                handler(){
                    this.$set(this.content, 'data', this.content_data);
                },
                deep: true
            }
        },
        computed: {
            ...mapGetters(['auth', 'system'])
        },
        methods: {
            ...mapActions(['read']),
            targetUpdate (target) {
                switch (this.media_update_type) {
                    case 'normal':
                        $('#' + this.media_target_id).val(this.system.public_path + target.path);
                        break;
                    case 'background-image':
                        if (this.grid_el != null) {
                            this.grid_el.css({
                                'background-image': 'url(' + this.system.public_path + target.path + ')',
                                'background-size': 'cover'
                            });
                            this.grid_el = null;
                        }
                        break;
                }
            },
            updateColorpicker(value){
                if (this.grid_el != null) {
                    this.grid_el.css({
                        'background-color': value
                    });
                }
            },
            closeTools(){
                $('#toolGridEditor-' + this.line).modal("hide");
                this.grid_el = null
            },
            updateContent(){
                this.content_data.content = $('#grid-editor-' + this.line).gridEditor('getHtml');
                this.$emit('updateContent', this.content);
            },
            loadEditor(){
                let o = this;
                $('#grid-editor-' + this.line).gridEditor({
                    valid_col_sizes: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    row_classes: [],
                    row_tools: [
                        {
                            title: 'Image de fond',
                            iconClass: 'fa fa-picture-o',
                            on: {
                                click: function () {
                                    o.grid_el = $(this).closest('.row');
                                    o.media_update_type = 'background-image';
                                    o.launch_media = !o.launch_media;
                                    $('#mediaLibrarygrid-editor-media-' + o.line).modal();
                                }
                            }
                        },
                        {
                            title: 'Couleur de fond',
                            iconClass: 'fa fa-eyedropper',
                            on: {
                                click: function () {
                                    o.grid_el = $(this).closest('.row');
                                    $('#toolGridEditor-' + o.line).modal();
                                }
                            }
                        }
                    ],
                    col_classes: [],
                    col_tools: [
                        {
                            title: 'Image de fond',
                            iconClass: 'fa fa-picture-o',
                            on: {
                                click: function () {
                                    o.grid_el = $(this).closest('.column');
                                    o.media_update_type = 'background-image';
                                    o.launch_media = !o.launch_media;
                                    $('#mediaLibrarygrid-editor-media-' + o.line).modal();
                                }
                            }
                        },
                        {
                            title: 'Couleur de fond',
                            iconClass: 'fa fa-eyedropper',
                            on: {
                                click: function () {
                                    o.grid_el = $(this).closest('.column');
                                    $('#toolGridEditor-' + o.line).modal();
                                }
                            }
                        }
                    ],
                    content_types: ['tinymce'],
                    content: o.content_data.content,
                    tinymce: {
                        config: {
                            relative_urls: false,
                            language: 'fr_FR',
                            plugins: [
                                'advlist autolink lists link image charmap print preview anchor',
                                'searchreplace visualblocks code fullscreen',
                                'insertdatetime media contextmenu paste table textcolor'
                            ],
                            toolbar: 'insertfile undo redo | styleselect forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table link image',
                            file_browser_callback: function (field_name, url, type, win) {
                                o.launch_media = !o.launch_media;
                                o.media_target_id = field_name;
                                $('#mediaLibrarygrid-editor-media-' + o.line).modal()
                            }
                        }
                    }
                });
            }
        },
        mounted(){
            this.$nextTick(function () {
                let o = this;
                if (this.content.data.content !== undefined)this.content_data = this.content.data;
                this.loadEditor();
                $('#mediaLibrarygrid-editor-media-' + o.line).on('show.bs.modal', () => {
                    $('.mce-panel.mce-window').hide();
                });

                $('#mediaLibrarygrid-editor-media-' + o.line).on('hide.bs.modal', () => {
                    $('.mce-panel.mce-window').show();
                });
            })
        }
    }
</script>