
import { VTooltip, VPopover, VClosePopover } from 'v-tooltip';
import vSelect from 'vue-select';
import BlockUI from 'vue-blockui';


Vue.component('v-select', vSelect);
Vue.use(BlockUI);

VTooltip.options.defaultTemplate = '<div class="tooltip-vue" role="tooltip"><div class="tooltip-vue-arrow"></div><div class="tooltip-vue-inner"></div></div>';
VTooltip.options.defaultArrowSelector = '.tooltip-vue-arrow, .tooltip-vue__arrow';
VTooltip.options.defaultInnerSelector = '.tooltip-vue-inner, .tooltip-vue__inner';

Vue.directive('tooltip', VTooltip);
Vue.directive('close-popover', VClosePopover);
Vue.component('v-popover', VPopover);








Vue.component('add-edit-customer', require('./components/admin/customers/AddEditCustomer.vue').default);
Vue.component('genealogy-tree', require('./components/admin/genealogy-tree/GenealogyTree.vue').default);
