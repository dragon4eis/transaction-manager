<template>
    <div v-show="shown"
         class="modal"
         role="dialog"
         tabindex="-1"
         @[escapeCloseEvent].esc.exact="close"
         @[outsideCloseEvent].stop="outsideCloseHandler">
        <div v-if="shown || keepAlive"
             :class="modalClasses"
             :style="modalStyles"
             class="modal-dialog modal-dialog-centered"
             role="document">
            <div ref="modal" class="modal-content border-0">
                <div v-if="hasHeader"
                     :class="headerClasses"
                     :style="headerStyles"
                     class="modal-header text-white bg-primary py-2">
                    <slot name="header">
                        <h5 class="modal-title text-truncate">
                            <slot name="title"></slot>
                        </h5>
                        <div class="btn-group float-right">
                            <slot name="header-buttons"></slot>
                            <button class="btn vm3-btn-outline-light d-inline py-0"
                                    type="button"
                                    @click.stop="close">
                                <i class="fas fa-fw fa-times text-light"></i>
                            </button>
                        </div>
                    </slot>
                </div>
                <div ref="body"
                     :class="bodyClasses"
                     :style="bodyStyles"
                     class="modal-body">
                    <slot name="body"></slot>
                </div>
                <div v-if="hasFooter"
                     :class="footerClasses"
                     :style="footerStyles"
                     class="modal-footer">
                    <slot name="footer">
                        <slot name="footer-buttons"></slot>
                        <button v-if="hasCloseButton"
                                class="btn btn-light text-dark border"
                                type="button"
                                @click.stop="close">
                            <slot name="close">Cancel</slot>
                        </button>
                        <button v-if="hasSubmitButton"
                                :disabled="disableSubmitButton"
                                class="btn btn-primary border"
                                type="button"
                                @click.stop="submit">
                            <slot name="submit">Save</slot>
                        </button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'generic-modal',
    props: {
        shown: {
            type: Boolean,
            default: false
        },
        hasHeader: {
            type: Boolean,
            default: true
        },
        hasFooter: {
            type: Boolean,
            default: true
        },
        hasCloseButton: {
            type: Boolean,
            default: true
        },
        hasFullScreenButton: {
            type: Boolean,
            default: false
        },
        hasSubmitButton: {
            type: Boolean,
            default: true
        },
        infoIconContent: {
            type: String,
            default: ''
        },
        infoIconTitle: {
            type: String,
            default: ''
        },
        infoIconPlacement: {
            type: String,
            default: 'top'
        },
        infoIconTrigger: {
            type: String,
            default: 'hover'
        },
        infoIconWidth: {
            type: String,
            default: ''
        },
        keepAlive: {
            type: Boolean,
            default: false
        },
        disableSubmitButton: {
            type: Boolean,
            default: false
        },
        escapeClose: {
            type: Boolean,
            default: true
        },
        outsideClose: {
            type: Boolean,
            default: false
        },
        modalClasses: {
            type: [String, Object, Array],
            default: ''
        },
        headerClasses: {
            type: [String, Object, Array],
            default: ''
        },
        bodyClasses: {
            type: [String, Object, Array],
            default: ''
        },
        footerClasses: {
            type: [String, Object, Array],
            default: ''
        },
        modalStyles: {
            type: [String, Object, Array],
            default: ''
        },
        headerStyles: {
            type: [String, Object, Array],
            default: ''
        },
        bodyStyles: {
            type: [String, Object, Array],
            default: ''
        },
        footerStyles: {
            type: [String, Object, Array],
            default: ''
        }
    },
    created() {
        this._isBodyOverflowing = false;
        this._scrollbarWidth = 0
    },
    mounted() {
        if (this.shown) {
            this.$el.focus()
        }
    },
    computed: {
        escapeCloseEvent() {
            return this.escapeClose ? 'keyup' : null
        },
        outsideCloseEvent() {
            return this.outsideClose ? 'click' : null
        }
    },
    watch: {
        shown(value) {
            if (value) {
                this.$nextTick(() => this.$el.focus());
                this._checkScrollbar();
                this._setScrollbar();
                this._adjustDialog();
                document.body.classList.add('modal-open')
            } else {
                document.body.classList.remove('modal-open');
                this._resetAdjustments();
                this._resetScrollbar()
            }
        }
    },
    methods: {
        outsideCloseHandler(event) {
            if (!this.$refs.modal.contains(event.target)) {
                this.close()
            }
        },
        close() {
            this.$emit('close')
        },
        submit() {
            this.$emit('submit')
        },
        fullscreen() {
            const fullscreenMethod =
                ['requestFullscreen', 'webkitRequestFullscreen', 'mozRequestFullScreen', 'msRequestFullscreen']
                    .find(method => method in this.$refs.body);
            this.$refs.body[fullscreenMethod]()
        },
        _adjustDialog() {
            const isModalOverflowing = this.$el.scrollHeight > document.documentElement.clientHeight;
            if (!this._isBodyOverflowing && isModalOverflowing) {
                this.$el.style.paddingLeft = `${this._scrollbarWidth}px`
            }
            if (this._isBodyOverflowing && !isModalOverflowing) {
                this.$el.style.paddingRight = `${this._scrollbarWidth}px`
            }
        },
        _resetAdjustments() {
            this.$el.style.paddingLeft = '';
            this.$el.style.paddingRight = ''
        },
        _checkScrollbar() {
            const rect = document.body.getBoundingClientRect();
            this._isBodyOverflowing = rect.left + rect.right < window.innerWidth;
            this._scrollbarWidth = this._getScrollbarWidth()
        },
        _setScrollbar() {
            if (this._isBodyOverflowing) {
                document.querySelectorAll('.fixed-top, .fixed-bottom, .is-fixed, .sticky-top').forEach(element => {
                    element.dataset.paddingRight = element.style.paddingRight;
                    element.style.paddingRight = `${parseFloat(getComputedStyle(element).paddingRight) + this._scrollbarWidth}px`
                });
                document.querySelectorAll('.sticky-top').forEach(element => {
                    element.dataset.marginRight = element.style.marginRight;
                    element.style.marginRight = `${parseFloat(getComputedStyle(element).marginRight) - this._scrollbarWidth}px`
                });
                document.querySelectorAll('.navbar-toggler, .vm3-right-menu').forEach(element => {
                    element.dataset.marginRight = element.style.marginRight;
                    element.style.marginRight = `${parseFloat(getComputedStyle(element).marginRight) + this._scrollbarWidth}px`
                });
                document.body.dataset.paddingRight = document.body.style.paddingRight;
                document.body.style.paddingRight = `${parseFloat(getComputedStyle(document.body).paddingRight) + this._scrollbarWidth}px`
            }
        },
        _resetScrollbar() {
            document.querySelectorAll('.fixed-top, .fixed-bottom, .is-fixed, .sticky-top').forEach(element => {
                const padding = element.dataset.paddingRight;
                if (typeof padding !== 'undefined') {
                    element.style.paddingRight = padding;
                    delete element.dataset.paddingRight
                }
            });
            document.querySelectorAll('.sticky-top, .navbar-toggler, .vm3-right-menu').forEach(element => {
                const margin = element.dataset.marginRight;
                if (typeof margin !== 'undefined') {
                    element.style.marginRight = margin;
                    delete element.dataset.marginRight
                }
            });
            const padding = document.body.dataset.paddingRight;
            if (typeof padding !== 'undefined') {
                document.body.style.paddingRight = padding;
                delete document.body.dataset.paddingRight
            }
        },
        _getScrollbarWidth() {
            const scrollDiv = document.createElement('div');
            scrollDiv.className = 'modal-scrollbar-measure';
            document.body.appendChild(scrollDiv);
            const scrollbarWidth = scrollDiv.getBoundingClientRect().width - scrollDiv.clientWidth;
            document.body.removeChild(scrollDiv);
            return scrollbarWidth
        }
    }
}
</script>

<style scoped>
.modal {
    background-color: rgba(0, 0, 0, 0.4);
    display: block;
    transition: opacity .3s ease;
}

.modal-content {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

.modal-header h5 {
    line-height: 40px;
}
</style>
