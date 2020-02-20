
import vSelect from 'vue-select';
import BlockUI from 'vue-blockui';


Vue.component('v-select', vSelect);
Vue.use(BlockUI);









Vue.component('add-edit-customer', require('./components/admin/customers/AddEditCustomer.vue').default);
Vue.component('genealogy-tree', require('./components/admin/genealogy-tree/GenealogyTree.vue').default);
