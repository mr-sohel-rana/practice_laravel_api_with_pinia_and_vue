 <template>
  <div>
    <h1>Home Page</h1>

    <ul class="mt-6">
      <li v-for="product in crud.posts" :key="product.id" class="m-4 flex justify-between">
        <span>
          <strong>{{ product.name }}</strong> - {{ product.details }} - {{ product.price }} Tk
        </span>
        <div class="flex gap-2">
          <button @click="handleDelete(product.id)" class="border-2 border-red-600 px-2 rounded">Delete</button>
          <button @click="handleEdit(product.id)" class="border-2 border-blue-600 px-2 rounded">Edit</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useCrudStore } from "../store/store";
import { useRouter } from "vue-router";

const crud = useCrudStore();
const router = useRouter();
const { destroy,index } = crud;



const handleDelete = async (id) => {
  if (confirm("Are you sure?")) {
    await  destroy(id);
    alert("Deleted successfully!");
  }
};
const handleEdit = (id) => {
  router.push({ name: "Create", query: { id:id } });
};
onMounted(async() =>
    await index()
);
</script>
