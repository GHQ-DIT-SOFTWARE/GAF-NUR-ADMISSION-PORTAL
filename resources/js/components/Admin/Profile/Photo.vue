<template>
    <div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <form @submit.prevent="submit" ref="formContainer" class="gy-3 form-settings vld-parent"
                @keydown="form.onKeydown($event)">
                <div class="col-md-6">
                    <div class="form-control-wrap">
                        <div style="width:200px; height:200px; border-radius: 60%;">
                            <vue-avatar :width=200 :height=200 :border="0.2" :rotation="0" :scale="1" ref="vueavatar"
                                :placeholderSvg="placeholderSvg" @vue-avatar-editor:image-ready="onImageReady">
                            </vue-avatar>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                        <button :form="form" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</template>
  
<script>
import Form from 'vform'
import {
    Button,
    HasError,
    AlertError
} from 'vform/src/components/bootstrap5'

import {
    VueAvatar
} from 'vue-avatar-editor-improved'

export default {
    components: {
        VueAvatar,
        Button,
        HasError,
        AlertError
    },
    data: () => ({
        placeholderSvg: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"><g><g transform="translate(0.000000,511.000000) scale(0.100000,-0.100000)"><path d="M4578.5,4997.6c-1228.5-127.1-2273.5-627.4-3106.7-1490.8C588.2,2590.9,100,1382.6,100,109.6c0-544.7,76.7-1018.8,254.2-1551.3c611.2-1841.8,2265.4-3151.1,4204.1-3330.6c320.8-30.3,863.4-16.1,1160,30.3c2144.4,328.8,3806.7,1991.1,4135.5,4135.5c46.4,296.6,60.5,839.2,30.3,1160c-179.6,1938.6-1488.8,3592.8-3330.6,4204.1c-373.2,123.1-625.4,179.5-1000.6,223.9C5322.9,5007.7,4770.1,5017.8,4578.5,4997.6z M5597.2,4454.9c1761.1-234,3225.7-1549.3,3661.4-3282.2c165.4-661.7,171.5-1392,16.1-2061.7c-133.1-574.9-431.7-1202.3-800.9-1678.4c-147.3-189.6-399.4-470-423.6-470c-8.1,0-26.2,66.6-38.3,149.3C7888.9-2099.3,7316-1359,6515.1-951.5c-320.8,163.4-633.4,264.3-1006.6,326.8c-383.3,62.5-631.4,62.5-1016.7-2C3473-796.1,2643.8-1367.1,2228.3-2182.1c-108.9-211.8-203.8-496.3-236-706c-12.1-82.7-30.3-149.3-38.3-149.3s-70.6,60.5-139.2,135.2c-631.4,673.8-1032.9,1511-1162,2416.7c-44.4,314.7-44.4,885.6,0,1190.2c143.2,974.4,562.8,1815.6,1250.7,2503.5C2885.9,4188.7,4215.3,4638.5,5597.2,4454.9z M5571-1161.3c1087.3-228,1886.2-1036.9,1946.7-1966.9l12.1-183.6l-141.2-113c-427.7-345-938-601.2-1460.5-734.3c-581-147.3-1270.9-147.3-1851.9,0c-526.5,133.1-1040.9,393.4-1462.6,734.3l-139.2,113l12.1,183.6c66.6,1004.6,968.3,1839.8,2172.7,2007.2C4864.9-1092.7,5347.1-1112.9,5571-1161.3z"/><path d="M4679.3,2923.8c-502.3-100.9-895.7-407.5-1111.5-865.4c-117-250.1-147.3-399.4-145.2-718.2c0-236,8.1-296.6,54.5-453.9c139.2-457.9,415.6-786.8,829.1-978.4C5105-467.3,6061.2-144.6,6426.3,624c115,240,155.3,427.7,155.3,726.2c2,385.3-86.7,671.8-296.6,966.3C5940.1,2800.7,5288.6,3046.8,4679.3,2923.8z M5306.7,2397.3c300.6-88.8,526.5-274.4,649.6-532.6c84.7-183.6,115-314.7,115-520.5c0-617.3-453.9-1073.2-1069.2-1073.2c-466,0-859.4,272.3-1010.7,696c-54.5,153.3-72.6,447.8-40.3,619.3c76.7,395.4,367.2,708.1,754.5,813C4852.8,2437.6,5169.5,2437.6,5306.7,2397.3z"/></g></g></svg>',

        form: new Form({
            new_upload: false,
        })
    }),
    methods: {
        submit() {
            var img = this.$refs.vueavatar.getImageScaled()
            this.form.avatar = img.toDataURL()
            let loader = this.$loading.show({
                container: this.$refs.formContainer,
            });

            this.$modal.hide('dialog')

            this.form.post(this.route('api.admin.profile.photo'))
                .then(({
                    data
                }) => {
                    loader.hide()
                    this.$toast.open('Operation Successful');

                })
                .catch((error) => {
                    loader.hide()
                });
        },
        onImageReady() {
            this.form.new_upload = true
        }

    },
    created() {

    },

}

</script>
  