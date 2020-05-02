
import { VTooltip, VPopover, VClosePopover } from 'v-tooltip';
import vSelect from 'vue-select';
import BlockUI from 'vue-blockui';
import HighchartsVue from 'highcharts-vue';


Vue.component('v-select', vSelect);
Vue.use(BlockUI);
Vue.use(HighchartsVue);

VTooltip.options.defaultTemplate = '<div class="tooltip-vue" role="tooltip"><div class="tooltip-vue-arrow"></div><div class="tooltip-vue-inner"></div></div>';
VTooltip.options.defaultArrowSelector = '.tooltip-vue-arrow, .tooltip-vue__arrow';
VTooltip.options.defaultInnerSelector = '.tooltip-vue-inner, .tooltip-vue__inner';

Vue.directive('tooltip', VTooltip);
Vue.directive('close-popover', VClosePopover);
Vue.component('v-popover', VPopover);








Vue.component('add-edit-customer', ()=> import('./components/admin/customers/AddEditCustomer.vue' /* webpackChunkName: "AddEditCustomer" */));
Vue.component('genealogy-tree', ()=> import('./components/admin/genealogy-tree/GenealogyTree.vue' /* webpackChunkName: "GenealogyTree" */));
Vue.component('payout-requests', ()=> import('./components/admin/request-payout/PayoutRequests.vue' /* webpackChunkName: "AddPayoutRequest" */));
Vue.component('payout-requests-admin', ()=> import('./components/admin/request-payout/PayoutRequestsAdmin.vue' /* webpackChunkName: "AddPayoutRequest" */));
Vue.component('add-payout-request', ()=> import('./components/admin/request-payout/AddPayoutRequests.vue' /* webpackChunkName: "AddPayoutRequest" */));
Vue.component('payout-request-list', ()=> import('./components/admin/request-payout/PayoutRequestList' /* webpackChunkName: "AddPayoutRequest" */));
Vue.component('payout-request-list-admin', ()=> import('./components/admin/request-payout/PayoutRequestListAdmin' /* webpackChunkName: "AddPayoutRequest" */));
Vue.component('admin-dashboard', ()=> import('./components/admin/dashboard/AdminDashboard' /* webpackChunkName: "AdminDashboard" */));
