 <template>
  <div class="border p-4 rounded shadow w-96 mx-auto mt-6">
    <h2 class="text-lg font-semibold mb-2">
      {{ editing ? "Update Image" : "Add New Image" }}
    </h2>

    <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
      <!-- Title -->
      <input
        type="text"
        v-model="form.title"
        placeholder="Title"
        class="border p-2 rounded mb-2 w-full"
        required
      />

      <!-- Image Upload -->
      <input
        type="file"
        @change="handleFile"
        class="border p-2 rounded mb-2 w-full"
        :required="!editing"
        accept="image/*"
      />

      <!-- Preview -->
      <div v-if="preview" class="mb-2">
        <img :src="preview" alt="Preview" class="w-full h-48 object-cover rounded" />
      </div>

      <!-- Submit Button -->
      <button
        type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded w-full"
      >
        {{ editing ? "Update" : "Add" }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useImageStore } from "../image_store/image";

const store = useImageStore();
const route = useRoute();
const router = useRouter();

const form = reactive({
  title: "",
  image: null,
});

const editing = ref(false);
const editId = ref(null);
const preview = ref(null); // for image preview

// Watch image file changes to update preview
watch(() => form.image, (file) => {
  if (file) {
    preview.value = URL.createObjectURL(file);
  }
});

// Load data if editing
onMounted(async () => {
  if (route.params.id) {
    editing.value = true;
    editId.value = route.params.id;
    await store.show(editId.value);
    const data = store.image;
    if (data) {
      form.title = data.title;
      preview.value = data.image_url; // show existing image
    }
  }
});

// Handle file selection
const handleFile = (e) => {
  form.image = e.target.files[0];
};

// Submit form
const handleSubmit = async () => {
  const data = new FormData();
  data.append("title", form.title);
  if (form.image) data.append("image", form.image);

  try {
    if (editing.value) {
      await store.update(editId.value, data);
      alert("Image updated successfully!");
    } else {
      await store.store(data);
      alert("Image added successfully!");
    }
    router.push("/all-images");
  } catch (err) {
    console.error(err);
    alert("Error submitting the form!");
  }
};
</script>
