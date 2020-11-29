import TransactionPage from "../../components/TransactionPage";
import {makeNestedRouterView} from "../config";
import NewTransactionModal from "../../components/modals/NewTransactionModal";

const storeModule = 'transaction';

export default {
    path: 'transaction',
    name: `${storeModule}-index`,
    components: {
        default: TransactionPage,
        ...makeNestedRouterView('modalView')
    },
    children: [
        {
            path: 'create',
            name: `${storeModule}-create`,
            props:{
                modalView: true,
            },
            components:{
                modalView: NewTransactionModal
            }
        }
    ]
}