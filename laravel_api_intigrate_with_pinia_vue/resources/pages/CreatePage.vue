<template>
    <div class="max-w-md mx-auto p-4 border rounded mt-6">
        <h1 class="text-2xl font-bold mb-4">
            {{ isEdit ? "Edit Product" : "Create Product" }}
        </h1>

        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label>Name:</label>
                <input
                    v-model="form.name"
                    type="text"
                    class="w-full border rounded p-2"
                    required
                />
            </div>

            <div>
                <label>Details:</label>
                <input
                    v-model="form.details"
                    type="text"
                    class="w-full border rounded p-2"
                    required
                />
            </div>

            <div>
                <label>Price:</label>
                <input
                    v-model.number="form.price"
                    type="number"
                    class="w-full border rounded p-2"
                    required
                />
            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                {{ isEdit ? "Update" : "Create" }}
            </button>
        </form>

    </div>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { useCrudStore } from "../store/store";
import { useRoute, useRouter } from "vue-router";

const crud = useCrudStore();
const { update, store, show } = crud;
const route = useRoute();
const router = useRouter();
const error = ref(null);

const form = reactive({
    name: "",
    details: "",
    price: null,
});

const isEdit = ref(false);
let editId = null;

const submitForm = async () => {
    try {
        if (isEdit.value) {
            await update(editId, form);
        } else {
            await store(form);
            form.name = "";
            form.details = "";
            form.price = null;
        }
        router.push({ name: "Home" });
    } catch (err) {
        console.error(err);
        error.value = "Failed to save product!";
    }
};

onMounted(async () => {
    const id = route.query.id;
    if (id) {
        isEdit.value = true;
        editId = parseInt(id);

        await show(editId);

        if (crud.post) {
            form.name = crud.post.name;
            form.details = crud.post.details;
            form.price = crud.post.price;
        }
    }
});
</script>
