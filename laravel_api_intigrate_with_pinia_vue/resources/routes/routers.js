import { createRouter, createWebHistory } from "vue-router";
import HomePage from "../pages/HomePage.vue";
import CreatePage from "../pages/CreatePage.vue";
import Images from "../pages/Images.vue";
import CreateUpdate from "../pages/CreateUpdate.vue";
const routes = [
    {
        path: '/',
        name: 'Home',
        component: HomePage,
    },
    {
        path: '/create',
        name: 'Create',
        component: CreatePage,
    },
    {
        path: '/all-images',
        name: 'Images',
        component:Images,
    },
     { path: '/image-create', name: 'CreateImage', component: CreateUpdate },
    { path: '/image-update/:id', name: 'UpdateImage', component: CreateUpdate, props: true },
]
const router = createRouter({ history: createWebHistory(), routes });
export default router;
