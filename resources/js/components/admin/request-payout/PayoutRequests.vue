<template>
    <div>
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-milestone"></i> Payout Requests
            </h1>
            <a href="/portal/request-payout/create" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>New Request</span>
            </a>
        </div>

        <div class="page-content browse container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <payout-request-list></payout-request-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
        }
    }
</script>
