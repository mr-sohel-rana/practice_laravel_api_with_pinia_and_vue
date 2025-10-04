 <template>
  <div class="flex justify-center items-center">
    <nav class=" mb-10">

      <router-link to="/">Home</router-link> |
      <router-link to="/create">Create</router-link> |
      <router-link to="/all-images">images</router-link>
    </nav>
    <router-view></router-view>
  </div>
</template>
