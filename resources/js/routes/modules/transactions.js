import {makeRedirect} from "../config";
import TransactionPage from "../../components/TransactionPage";

const storeModule = 'transaction';

export default {
    path: 'transaction',
    name: `${storeModule}-index`,
    // redirect: makeRedirect(`${storeModule}-create`),
    component: TransactionPage,

}