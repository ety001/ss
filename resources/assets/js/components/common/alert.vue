<script>
    export default {
        props: ['className', 'displayTag'],
        render: function (createElement) {
            return createElement(
                'div',
                {
                    'class': {
                        'hide': !this.displayTag,
                        'alert': true,
                        'alert-success': this.className == 'success',
                        'alert-info': this.className == 'info',
                        'alert-warning': this.className == 'warning',
                        'alert-danger': this.className == 'danger'
                    }
                },
                this.$slots.default
            )
        }
    }
</script>
