<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

// Sample data for wedding templates
const weddingTemplates = [
  { id: 1, name: 'Elegant Floral', image: '/images/templates/elegant-floral.jpg', preview: '/demo/elegant-floral' },
  { id: 2, name: 'Rustic Charm', image: '/images/templates/rustic-charm.jpg', preview: '/demo/rustic-charm' },
  { id: 3, name: 'Modern Minimalist', image: '/images/templates/modern-minimal.jpg', preview: '/demo/modern-minimal' },
  { id: 4, name: 'Classic Romance', image: '/images/templates/classic-romance.jpg', preview: '/demo/classic-romance' },
  { id: 5, name: 'Beach Paradise', image: '/images/templates/beach-paradise.jpg', preview: '/demo/beach-paradise' },
  { id: 6, name: 'Garden Wedding', image: '/images/templates/garden-wedding.jpg', preview: '/demo/garden-wedding' },
];

// Pricing plans
const pricingPlans = [
  {
    name: 'Basic',
    price: '99K',
    features: [
      '1 Template Design',
      '50 WA Blasts',
      '1 Month Active',
      'Basic Support',
    ],
    recommended: false,
    ctaLink: 'https://wa.me/6281234567890?text=Saya%20tertarik%20dengan%20paket%20Basic'
  },
  {
    name: 'Premium',
    price: '199K',
    features: [
      '3 Template Designs',
      '200 WA Blasts',
      '3 Months Active',
      'Premium Support',
      'RSVP Management',
    ],
    recommended: true,
    ctaLink: 'https://wa.me/6281234567890?text=Saya%20tertarik%20dengan%20paket%20Premium'
  },
  {
    name: 'Gold',
    price: '349K',
    features: [
      'All Template Designs',
      'Unlimited WA Blasts',
      '6 Months Active',
      'Priority Support',
      'RSVP Management',
      'Custom Domain',
    ],
    recommended: false,
    ctaLink: 'https://wa.me/6281234567890?text=Saya%20tertarik%20dengan%20paket%20Gold'
  }
];

// Key features
const keyFeatures = [
  {
    title: 'Mass WA Invitation',
    description: 'Send your wedding invitation to all your contacts with just one click',
    icon: 'chat-bubble'
  },
  {
    title: 'Beautiful Templates',
    description: 'Choose from our collection of professionally designed wedding templates',
    icon: 'template'
  },
  {
    title: 'RSVP Management',
    description: 'Easily track guest responses and manage your attendee list',
    icon: 'check'
  },
  {
    title: 'Photo Gallery',
    description: 'Share your precious moments with guests in an elegant photo gallery',
    icon: 'image'
  }
];
</script>

<template>
    <Head title="Wedding Invitation App">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
        <!-- Header/Navigation -->
        <header class="border-b border-gray-100 dark:border-gray-800">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="text-2xl font-bold">Wedding<span class="text-pink-500">Pro</span></div>
                    <nav class="flex items-center gap-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                        >
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                            >
                                Log in
                            </Link>
                            <Link
                                :href="route('register')"
                                class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="py-20 bg-gradient-to-b from-pink-50 to-white dark:from-gray-900 dark:to-black">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-8">Create Beautiful Digital Wedding Invitations</h1>
                <p class="text-xl mb-10 max-w-2xl mx-auto">Design stunning wedding invitations and send them to all your guests with a single click through WhatsApp.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <Link
                        :href="route('register')"
                        class="px-8 py-3 bg-pink-500 hover:bg-pink-600 text-white rounded-md font-semibold transition"
                    >
                        Get Started Free
                    </Link>
                    <a
                        href="#templates"
                        class="px-8 py-3 border border-pink-500 hover:bg-pink-50 dark:hover:bg-gray-800 text-pink-500 rounded-md font-semibold transition"
                    >
                        View Templates
                    </a>
                </div>
            </div>
        </section>

        <!-- Template Showcase -->
        <section id="templates" class="py-16">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold mb-4">Beautiful Wedding Templates</h2>
                    <p class="text-lg max-w-2xl mx-auto opacity-80">Choose from our collection of professionally designed templates to create your perfect wedding invitation.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="template in weddingTemplates" :key="template.id" class="rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 bg-white dark:bg-gray-800">
                        <div class="h-64 overflow-hidden">
                            <img :src="template.image" alt="Template Preview" class="w-full h-full object-cover" />
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-xl mb-2">{{ template.name }}</h3>
                            <div class="flex justify-between items-center mt-4">
                                <a :href="template.preview" class="text-pink-500 hover:text-pink-600 font-medium">View Demo</a>
                                <Link
                                    :href="route('register')"
                                    class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-md text-sm font-semibold transition"
                                >
                                    Use Template
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Key Features Section -->
        <section class="py-16 bg-pink-50 dark:bg-gray-900">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold mb-4">Why Choose Us</h2>
                    <p class="text-lg max-w-2xl mx-auto opacity-80">Our platform offers everything you need to create and share your perfect wedding invitation.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div v-for="(feature, index) in keyFeatures" :key="index" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" v-if="feature.icon === 'chat-bubble'"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" v-if="feature.icon === 'template'"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" v-if="feature.icon === 'check'"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" v-if="feature.icon === 'image'"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ feature.title }}</h3>
                        <p class="opacity-80">{{ feature.description }}</p>
                    </div>
                </div>

                <!-- WhatsApp Highlight Feature -->
                <div class="mt-16 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <div class="md:flex">
                        <div class="md:w-1/2 p-8 md:p-12">
                            <h3 class="text-2xl font-bold mb-4">Mass WhatsApp Invitations</h3>
                            <p class="text-lg mb-6">Our special feature lets you send your beautiful invitation to all your guests with just one click!</p>
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-pink-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Upload your contacts once</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-pink-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Personalize each message automatically</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-pink-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Send to hundreds of contacts with one click</span>
                                </li>
                            </ul>
                            <Link
                                :href="route('register')"
                                class="inline-block px-6 py-3 bg-pink-500 hover:bg-pink-600 text-white rounded-md font-semibold transition"
                            >
                                Try It Now
                            </Link>
                        </div>
                        <div class="md:w-1/2 bg-gray-100 dark:bg-gray-700 flex items-center justify-center p-6">
                            <img src="/images/wa-blast-feature.png" alt="WhatsApp Blast Feature" class="max-w-full h-auto rounded-lg shadow-md" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section class="py-16">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold mb-4">Simple, Transparent Pricing</h2>
                    <p class="text-lg max-w-2xl mx-auto opacity-80">Choose the perfect plan for your wedding invitation needs.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div
                        v-for="(plan, index) in pricingPlans"
                        :key="index"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:-translate-y-2"
                        :class="{'border-2 border-pink-500 relative': plan.recommended}"
                    >
                        <div v-if="plan.recommended" class="bg-pink-500 text-white text-center py-1 font-medium">
                            Most Popular
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-bold mb-2">{{ plan.name }}</h3>
                            <div class="flex items-end mb-6">
                                <span class="text-4xl font-bold">Rp {{ plan.price }}</span>
                            </div>
                            <ul class="space-y-3 mb-8">
                                <li v-for="(feature, i) in plan.features" :key="i" class="flex items-start">
                                    <svg class="w-5 h-5 text-pink-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>{{ feature }}</span>
                                </li>
                            </ul>
                            <a
                                :href="plan.ctaLink"
                                class="block w-full py-3 text-center rounded-md font-semibold transition"
                                :class="plan.recommended ? 'bg-pink-500 hover:bg-pink-600 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600'"
                                target="_blank"
                            >
                                Order via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="py-16 bg-pink-600 text-white">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-4">Ready to Create Your Perfect Wedding Invitation?</h2>
                <p class="text-xl mb-8 max-w-2xl mx-auto opacity-90">Join thousands of couples who have created beautiful digital invitations with us.</p>
                <Link
                    :href="route('register')"
                    class="inline-block px-8 py-3 bg-white text-pink-600 hover:bg-gray-100 rounded-md font-semibold transition"
                >
                    Get Started Today
                </Link>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-12 bg-gray-100 dark:bg-gray-900">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-6 md:mb-0">
                        <div class="text-xl font-bold">Wedding<span class="text-pink-500">Pro</span></div>
                        <p class="mt-2 text-sm opacity-80">Beautiful digital wedding invitations made easy.</p>
                    </div>
                    <div class="flex gap-6">
                        <a href="#" class="opacity-80 hover:opacity-100 transition">Terms</a>
                        <a href="#" class="opacity-80 hover:opacity-100 transition">Privacy</a>
                        <a href="#" class="opacity-80 hover:opacity-100 transition">Contact</a>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-800 text-sm opacity-70 text-center">
                    &copy; {{ new Date().getFullYear() }} WeddingPro. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</template>
