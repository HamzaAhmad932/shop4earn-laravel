<template>
    <div>
        <div class="page-content">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <apexchart width="100%" type="bar" :options="line_bar.options" :series="line_bar.series"></apexchart>
                        </div>
                        <div class="col-lg-4">
                            <apexchart width="100%" type="donut" :options="donut.options" :series="donut.series"></apexchart>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
                line_bar:{
                    options: {
                        chart: {
                            id: 'vuechart-example'
                        },
                        xaxis: {
                            categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
                        }
                    },
                    series: [{
                        name: 'series-1',
                        data: [30, 40, 45, 50, 49, 60, 70, 91]
                    }]
                },
                donut: {
                    options: {},
                    series: [44, 55]
                }
            }
        },

        mounted(){
            console.log('component mounted')
        }
    }
</script>
