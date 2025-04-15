<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

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

// Testimonials from happy couples
const testimonials = [
  {
    name: 'Andi & Sari',
    image: '/images/testimonials/couple1.jpg',
    text: 'WeddingPro made our special day even more memorable. The templates were gorgeous and the WhatsApp blast feature saved us so much time!',
    rating: 5
  },
  {
    name: 'Budi & Maya',
    image: '/images/testimonials/couple2.jpg',
    text: 'We loved how easy it was to customize our invitation. Our guests were impressed by the beautiful design and interactive features.',
    rating: 5
  },
  {
    name: 'Citra & Dimas',
    image: '/images/testimonials/couple3.jpg',
    text: 'The RSVP management system was a lifesaver! We could easily keep track of who was coming and plan accordingly.',
    rating: 4
  }
];

// FAQ items
const faqItems = ref([
  {
    question: 'How does the WhatsApp blast feature work?',
    answer: 'Our platform allows you to upload your guest list with their phone numbers. You can then send personalized invitation links to all your guests with just one click through WhatsApp.',
    isOpen: false
  },
  {
    question: 'Can I customize the templates?',
    answer: 'Yes! All our templates can be fully customized with your names, wedding details, photos, and color schemes to match your wedding theme.',
    isOpen: false
  },
  {
    question: 'How long will my invitation website be active?',
    answer: 'The duration depends on your chosen package. Basic: 1 month, Premium: 3 months, and Gold: 6 months. You can also extend the duration if needed.',
    isOpen: false
  },
  {
    question: 'Is it mobile-friendly?',
    answer: 'Absolutely! All our wedding invitation websites are fully responsive and work beautifully on all devices - smartphones, tablets, and computers.',
    isOpen: false
  }
]);

// Toggle FAQ item
const toggleFaq = (index) => {
  faqItems.value = faqItems.value.map((item, i) => {
    if (i === index) {
      return { ...item, isOpen: !item.isOpen };
    } else {
      return { ...item, isOpen: false };
    }
  });
};

// Animation on scroll
const isVisible = ref({
  hero: false,
  templates: false,
  features: false,
  whatsapp: false,
  pricing: false,
  testimonials: false,
  faq: false,
  cta: false
});

// Smooth scrolling function
const smoothScroll = (e, target) => {
  e.preventDefault();
  const element = document.querySelector(target);
  if (element) {
    const headerOffset = 80; // Adjust this value based on your header height
    const elementPosition = element.getBoundingClientRect().top;
    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

    window.scrollTo({
      top: offsetPosition,
      behavior: 'smooth'
    });
  }
};

onMounted(() => {
  // Set initial visibility
  isVisible.value.hero = true;

  // Setup intersection observer for scroll animations
  const observerOptions = {
    threshold: 0.1
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        if (entry.target.id === 'templates-section') isVisible.value.templates = true;
        if (entry.target.id === 'features-section') isVisible.value.features = true;
        if (entry.target.id === 'whatsapp-feature') isVisible.value.whatsapp = true;
        if (entry.target.id === 'pricing-section') isVisible.value.pricing = true;
        if (entry.target.id === 'testimonials-section') isVisible.value.testimonials = true;
        if (entry.target.id === 'faq-section') isVisible.value.faq = true;
        if (entry.target.id === 'cta-section') isVisible.value.cta = true;
      }
    });
  }, observerOptions);

  // Observe all sections
  document.querySelectorAll('section[id]').forEach(section => {
    observer.observe(section);
  });
});
</script>

<template>
    <Head title="Wedding Invitation App">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    </Head>

    <div class="font-sans bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
        <!-- Header/Navigation -->
        <header class="fixed w-full z-50 bg-white/90 dark:bg-black/90 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 shadow-sm">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="text-2xl font-serif font-bold">Wedding<span class="text-pink-500">Pro</span></span>
                    </div>
                    <nav class="flex items-center gap-6">
                        <a href="#templates-section" class="hidden md:block font-medium text-sm hover:text-pink-500 transition" @click="smoothScroll($event, '#templates-section')">Templates</a>
                        <a href="#features-section" class="hidden md:block font-medium text-sm hover:text-pink-500 transition" @click="smoothScroll($event, '#features-section')">Features</a>
                        <a href="#pricing-section" class="hidden md:block font-medium text-sm hover:text-pink-500 transition" @click="smoothScroll($event, '#pricing-section')">Pricing</a>
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="inline-block rounded-full bg-pink-500 px-5 py-2 text-sm font-medium text-white hover:bg-pink-600 transition duration-300"
                        >
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="inline-block font-medium text-sm hover:text-pink-500 transition"
                            >
                                Log in
                            </Link>
                            <Link
                                :href="route('register')"
                                class="inline-block rounded-full bg-pink-500 px-5 py-2 text-sm font-medium text-white hover:bg-pink-600 transition duration-300"
                            >
                                Get Started
                            </Link>
                        </template>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 overflow-hidden" :class="{ 'animate-fadeIn': isVisible.hero }">
            <div class="absolute inset-0 bg-[url('/images/hero-pattern.svg')] bg-repeat opacity-5"></div>
            <div class="absolute -top-10 -right-10 w-72 h-72 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute -bottom-8 -left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="container mx-auto px-6 relative">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Undangan Pernikahan Digital <span class="text-pink-500">Elegan</span> untuk Hari Spesial Anda
                    </h1>
                    <p class="text-xl mb-10 max-w-2xl mx-auto opacity-80">
                        Buat undangan pernikahan digital yang memukau dan kirimkan ke semua tamu Anda dengan satu klik melalui WhatsApp.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <Link
                            :href="route('register')"
                            class="px-8 py-4 bg-pink-500 hover:bg-pink-600 text-white rounded-full font-medium transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg"
                        >
                            Mulai Gratis
                        </Link>
                        <a
                            href="#templates"
                            class="px-8 py-4 border-2 border-pink-500 hover:bg-pink-50 dark:hover:bg-pink-950/20 text-pink-500 rounded-full font-medium transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg"
                            @click="smoothScroll($event, '#templates-section')"
                        >
                            Lihat Template
                        </a>
                    </div>
                    <div class="mt-12 relative">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#FDFDFC] dark:from-[#0a0a0a] z-10 h-16 bottom-0"></div>
                        <img src="/images/hero-mockup.png" alt="Wedding Invitation Preview" class="mx-auto rounded-xl shadow-2xl" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-12 border-y border-gray-100 dark:border-gray-800">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div class="flex flex-col items-center">
                        <div class="text-4xl font-bold text-pink-500 mb-2">10K+</div>
                        <div class="text-sm opacity-70">Pasangan Bahagia</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="text-4xl font-bold text-pink-500 mb-2">50+</div>
                        <div class="text-sm opacity-70">Template Premium</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="text-4xl font-bold text-pink-500 mb-2">1Jt+</div>
                        <div class="text-sm opacity-70">Tamu Diundang</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="text-4xl font-bold text-pink-500 mb-2">4.9</div>
                        <div class="text-sm opacity-70">Rating Pelanggan</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Template Showcase -->
        <section id="templates-section" class="py-20">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" :class="{ 'opacity-0 translate-y-10 transition duration-1000 ease-out': !isVisible.templates, 'opacity-100 translate-y-0': isVisible.templates }">
                    <h2 class="font-serif text-3xl lg:text-4xl font-bold mb-4">Template Pernikahan yang Menakjubkan</h2>
                    <p class="text-lg max-w-2xl mx-auto opacity-80">Pilih dari koleksi template yang dirancang secara profesional untuk membuat undangan pernikahan sempurna.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        v-for="(template, index) in weddingTemplates"
                        :key="template.id"
                        class="group rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 bg-white dark:bg-gray-800"
                        :class="{ 'opacity-0 translate-y-10 transition duration-700 ease-out': !isVisible.templates, 'opacity-100 translate-y-0 transition-delay': isVisible.templates }"
                        :style="{ transitionDelay: `${index * 150}ms` }"
                    >
                        <div class="h-72 overflow-hidden">
                            <img :src="template.image" alt="Template Preview" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                        </div>
                        <div class="p-6">
                            <h3 class="font-serif font-bold text-xl mb-3">{{ template.name }}</h3>
                            <div class="flex justify-between items-center mt-4">
                                <a
                                    :href="template.preview"
                                    class="text-pink-500 hover:text-pink-600 font-medium transition-colors flex items-center gap-2"
                                >
                                    <span>Lihat Demo</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                                <Link
                                    :href="route('register')"
                                    class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-full text-sm font-medium transition-all duration-300"
                                >
                                    Gunakan Template
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-center">
                    <Link
                        :href="route('register')"
                        class="inline-flex items-center gap-2 text-pink-500 hover:text-pink-600 font-medium transition-colors"
                    >
                        <span>Lihat Semua Template</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Key Features Section -->
        <section id="features-section" class="py-20 bg-gradient-to-b from-pink-50 to-white dark:from-gray-900 dark:to-black">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" :class="{ 'opacity-0 translate-y-10 transition duration-1000 ease-out': !isVisible.features, 'opacity-100 translate-y-0': isVisible.features }">
                    <h2 class="font-serif text-3xl lg:text-4xl font-bold mb-4">Mengapa Memilih Kami</h2>
                    <p class="text-lg max-w-2xl mx-auto opacity-80">Platform kami menawarkan semua yang Anda butuhkan untuk membuat dan berbagi undangan pernikahan sempurna.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div
                        v-for="(feature, index) in keyFeatures"
                        :key="index"
                        class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300"
                        :class="{ 'opacity-0 translate-y-10 transition duration-700 ease-out': !isVisible.features, 'opacity-100 translate-y-0 transition-delay': isVisible.features }"
                        :style="{ transitionDelay: `${index * 150}ms` }"
                    >
                        <div class="w-16 h-16 bg-pink-100 dark:bg-pink-900 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" v-if="feature.icon === 'chat-bubble'"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" v-if="feature.icon === 'template'"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" v-if="feature.icon === 'check'"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" v-if="feature.icon === 'image'"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">{{ feature.title }}</h3>
                        <p class="opacity-80">{{ feature.description }}</p>
                    </div>
                </div>

                <!-- WhatsApp Highlight Feature -->
                <div id="whatsapp-feature" class="mt-20" :class="{ 'opacity-0 translate-y-10 transition duration-1000 ease-out': !isVisible.whatsapp, 'opacity-100 translate-y-0': isVisible.whatsapp }">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                        <div class="md:flex">
                            <div class="md:w-1/2 p-8 md:p-12 lg:p-16">
                                <div class="inline-block px-3 py-1 bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 text-sm font-medium rounded-full mb-4">
                                    Fitur Unggulan
                                </div>
                                <h3 class="text-2xl lg:text-3xl font-bold mb-6">Undangan Massal via WhatsApp</h3>
                                <p class="text-lg mb-8 opacity-80">Fitur spesial kami memungkinkan Anda mengirim undangan yang indah ke semua tamu hanya dengan satu klik!</p>
                                <ul class="space-y-4 mb-8">
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-pink-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Upload kontak Anda sekali saja</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-pink-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Personalisasi setiap pesan secara otomatis</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-pink-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Kirim ke ratusan kontak dengan satu klik</span>
                                    </li>
                                </ul>
                                <Link
                                    :href="route('register')"
                                    class="inline-block px-8 py-4 bg-pink-500 hover:bg-pink-600 text-white rounded-full font-medium transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg"
                                >
                                    Coba Sekarang
                                </Link>
                            </div>
                            <div class="md:w-1/2 bg-gradient-to-br from-pink-50 to-purple-50 dark:from-pink-900/20 dark:to-purple-900/20 flex items-center justify-center p-6">
                                <div class="relative">
                                    <div class="absolute -top-6 -left-6 w-40 h-40 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-50 animate-blob"></div>
                                    <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-50 animate-blob animation-delay-2000"></div>
                                    <img src="/images/wa-blast-feature.png" alt="WhatsApp Blast Feature" class="relative z-10 max-w-full h-auto rounded-xl shadow-xl" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials-section" class="py-20">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" :class="{ 'opacity-0 translate-y-10 transition duration-1000 ease-out': !isVisible.testimonials, 'opacity-100 translate-y-0': isVisible.testimonials }">
                    <h2 class="font-serif text-3xl lg:text-4xl font-bold mb-4">Apa Kata Pasangan Bahagia Kami</h2>
                    <p class="text-lg max-w-2xl mx-auto opacity-80">Dengarkan pengalaman pasangan yang telah menggunakan layanan kami untuk undangan pernikahan mereka.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div
                        v-for="(testimonial, index) in testimonials"
                        :key="index"
                        class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg"
                        :class="{ 'opacity-0 translate-y-10 transition duration-700 ease-out': !isVisible.testimonials, 'opacity-100 translate-y-0': isVisible.testimonials }"
                        :style="{ transitionDelay: `${index * 150}ms` }"
                    >
                        <div class="flex items-center gap-4 mb-6">
                            <img :src="testimonial.image" alt="Couple" class="w-16 h-16 rounded-full object-cover" />
                            <div>
                                <h4 class="font-bold">{{ testimonial.name }}</h4>
                                <div class="flex items-center">
                                    <div v-for="i in 5" :key="i" class="text-yellow-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" :fill="i <= testimonial.rating ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="italic opacity-80">{{ testimonial.text }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing-section" class="py-20 bg-gradient-to-b from-pink-50 to-white dark:from-gray-900 dark:to-black">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" :class="{ 'opacity-0 translate-y-10 transition duration-1000 ease-out': !isVisible.pricing, 'opacity-100 translate-y-0': isVisible.pricing }">
                    <h2 class="font-serif text-3xl lg:text-4xl font-bold mb-4">Harga Sederhana & Transparan</h2>
                    <p class="text-lg max-w-2xl mx-auto opacity-80">Pilih paket yang sesuai dengan kebutuhan undangan pernikahan Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div
                        v-for="(plan, index) in pricingPlans"
                        :key="index"
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2"
                        :class="[
                            plan.recommended ? 'border-2 border-pink-500 relative z-10 scale-105 md:scale-110' : '',
                            { 'opacity-0 translate-y-10 transition duration-700 ease-out': !isVisible.pricing, 'opacity-100 translate-y-0': isVisible.pricing }
                        ]"
                        :style="{ transitionDelay: `${index * 150}ms` }"
                    >
                        <div v-if="plan.recommended" class="bg-pink-500 text-white text-center py-2 font-medium">
                            Paling Populer
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-bold mb-2">{{ plan.name }}</h3>
                            <div class="flex items-end mb-6">
                                <span class="text-4xl font-serif font-bold text-pink-500">Rp {{ plan.price }}</span>
                            </div>
                            <ul class="space-y-4 mb-8">
                                <li v-for="(feature, i) in plan.features" :key="i" class="flex items-start">
                                    <svg class="w-5 h-5 text-pink-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>{{ feature }}</span>
                                </li>
                            </ul>
                            <a
                                :href="plan.ctaLink"
                                class="block w-full py-4 text-center rounded-full font-medium transition-all duration-300"
                                :class="plan.recommended ? 'bg-pink-500 hover:bg-pink-600 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600'"
                                target="_blank"
                            >
                                Pesan via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq-section" class="py-20">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" :class="{ 'opacity-0 translate-y-10 transition duration-1000 ease-out': !isVisible.faq, 'opacity-100 translate-y-0': isVisible.faq }">
                    <h2 class="font-serif text-3xl lg:text-4xl font-bold mb-4">Pertanyaan yang Sering Diajukan</h2>
                    <p class="text-lg max-w-2xl mx-auto opacity-80">Temukan jawaban untuk pertanyaan umum tentang layanan kami.</p>
                </div>

                <div class="max-w-3xl mx-auto">
                    <div
                        v-for="(faq, index) in faqItems"
                        :key="index"
                        class="mb-4"
                        :class="{ 'opacity-0 translate-y-10 transition duration-700 ease-out': !isVisible.faq, 'opacity-100 translate-y-0': isVisible.faq }"
                        :style="{ transitionDelay: `${index * 150}ms` }"
                    >
                        <button
                            @click="toggleFaq(index)"
                            class="flex justify-between items-center w-full p-6 text-left bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-all duration-300"
                            :class="{ 'rounded-b-none': faq.isOpen }"
                        >
                            <span class="font-bold">{{ faq.question }}</span>
                            <svg
                                class="w-5 h-5 transition-transform duration-300"
                                :class="{ 'transform rotate-180': faq.isOpen }"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            v-if="faq.isOpen"
                            class="p-6 bg-white dark:bg-gray-800 rounded-b-lg shadow border-t border-gray-100 dark:border-gray-700"
                        >
                            <p class="opacity-80">{{ faq.answer }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section id="cta-section" class="py-20 bg-gradient-to-r from-pink-500 to-purple-600 text-white">
            <div class="container mx-auto px-6 text-center">
                <div :class="{ 'opacity-0 translate-y-10 transition duration-1000 ease-out': !isVisible.cta, 'opacity-100 translate-y-0': isVisible.cta }">
                    <h2 class="font-serif text-3xl lg:text-4xl font-bold mb-4">Siap Membuat Undangan Pernikahan Sempurna?</h2>
                    <p class="text-xl mb-10 max-w-2xl mx-auto opacity-90">Bergabung dengan ribuan pasangan yang telah membuat undangan digital yang indah bersama kami.</p>
                    <Link
                        :href="route('register')"
                        class="inline-block px-8 py-4 bg-white text-pink-600 hover:bg-gray-100 rounded-full font-bold transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg"
                    >
                        Mulai Hari Ini
                    </Link>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-12 bg-gray-100 dark:bg-gray-900">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div class="md:col-span-2">
                        <div class="text-2xl font-serif font-bold mb-4">Wedding<span class="text-pink-500">Pro</span></div>
                        <p class="mb-4 max-w-md opacity-80">Undangan pernikahan digital yang indah dan mudah dibuat. Buat undangan Anda dalam hitungan menit dan bagikan kepada tamu Anda dengan satu klik.</p>
                        <div class="flex gap-4">
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center hover:bg-pink-100 dark:hover:bg-pink-900/30 transition-colors">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center hover:bg-pink-100 dark:hover:bg-pink-900/30 transition-colors">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center hover:bg-pink-100 dark:hover:bg-pink-900/30 transition-colors">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-bold mb-4">Menu</h4>
                        <ul class="space-y-2">
                            <li><a href="#templates-section" class="opacity-80 hover:opacity-100 hover:text-pink-500 transition" @click="smoothScroll($event, '#templates-section')">Templates</a></li>
                            <li><a href="#features-section" class="opacity-80 hover:opacity-100 hover:text-pink-500 transition" @click="smoothScroll($event, '#features-section')">Fitur</a></li>
                            <li><a href="#pricing-section" class="opacity-80 hover:opacity-100 hover:text-pink-500 transition" @click="smoothScroll($event, '#pricing-section')">Harga</a></li>
                            <li><a href="#testimonials-section" class="opacity-80 hover:opacity-100 hover:text-pink-500 transition" @click="smoothScroll($event, '#testimonials-section')">Testimonial</a></li>
                            <li><a href="#faq-section" class="opacity-80 hover:opacity-100 hover:text-pink-500 transition" @click="smoothScroll($event, '#faq-section')">FAQ</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold mb-4">Kontak</h4>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="opacity-80">info@wedding-pro.com</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="opacity-80">+62 812-3456-7890</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="pt-8 border-t border-gray-200 dark:border-gray-800 text-sm opacity-70 text-center">
                    <p>&copy; {{ new Date().getFullYear() }} WeddingPro. Hak Cipta Dilindungi.</p>
                    <div class="flex justify-center gap-6 mt-2">
                        <a href="#" class="hover:text-pink-500 transition">Syarat & Ketentuan</a>
                        <a href="#" class="hover:text-pink-500 transition">Kebijakan Privasi</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style>
.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.transition-delay {
    transition-delay: calc(var(--i, 0) * 100ms);
}

.font-serif {
    font-family: 'Playfair Display', serif;
}

.font-sans {
    font-family: 'Poppins', sans-serif;
}
</style>
