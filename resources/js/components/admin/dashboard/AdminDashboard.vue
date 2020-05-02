<template>
    <div>
        <div class="page-content">
            <div class="row">
                <div class="col-lg-4">
                    <highcharts :options="chartOptions"></highcharts>
                </div>
                <div class="col-lg-4"></div>
                <div class="col-lg-4"></div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
                chartOptions: {
                    series: [{
                        data: [1,2,3] // sample data
                    }]
                }
            }
        },

        mounted(){
            console.log('component mounted')
        }
    }
</script>
