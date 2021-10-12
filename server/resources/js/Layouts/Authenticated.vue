<template>
  <div>
    <div class="min-h-screen bg-gray-100">
      <nav class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="flex-shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                <p>Logo</p>
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <Link href="/dashboard">
                Dashboard
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
          :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
          class="sm:hidden"
        >
          <div class="pt-2 pb-3 space-y-1">
            <Link href="/dashboard">
            Dashboard
            </Link>
          </div>

          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
              <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
              <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
            </div>

            <div class="mt-3 space-y-1">
              <Link href="/dashboard">
              Logout
              </Link>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header
        class="bg-white shadow"
        v-if="$slots.header"
      >
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link,
  },

  data() {
    return {
      showingNavigationDropdown: false,
    };
  },
};
</script>
