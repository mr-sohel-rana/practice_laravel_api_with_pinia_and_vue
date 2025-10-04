 <template>
  <div>
    <h1 class="text-2xl font-bold mb-4">All Images</h1>

    <button
      @click="goCreate"
      class="bg-green-500 text-white px-4 py-2 rounded mb-4"
    >
      Add New Image
    </button>

    <div class="grid grid-cols-3 gap-4" v-if="store.images.length">
      <div v-for="img in store.images" :key="img.id" class="border p-2 rounded shadow">
        <img :src="img.image_url" :alt="img.title" class="w-full h-48 object-cover mb-2" />
        <h2 class="text-lg font-semibold">{{ img.title }}</h2>
        <button
          @click="goEdit(img.id)"
          class="bg-yellow-400 px-2 py-1 rounded mr-2"
        >
          Edit
        </button>
        <button
          @click="deleteImage(img.id)"
          class="bg-red-500 px-2 py-1 rounded text-white"
        >
          Delete
        </button>
      </div>
    </div>

    <div v-else>No images found.</div>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useRouter } from "vue-router";
import { useImageStore } from "../image_store/image";

const store = useImageStore();
const router = useRouter();

onMounted(async () => {
  await store.index();
});

const goCreate = () => {
  router.push({ name: "CreateImage" });
};

const goEdit = (id) => {
  router.push({ name: "UpdateImage", params: { id } });
};

const deleteImage = async (id) => {
  if (confirm("Are you sure?")) {
    await store.destroy(id);
  }
};
</script>
