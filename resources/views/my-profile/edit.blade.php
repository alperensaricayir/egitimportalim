@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Profili Düzenle</h1>
                    <a href="{{ route('my.profile.show') }}" 
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        İptal
                    </a>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('my.profile.update') }}" method="POST" enctype="multipart/form-data" class="px-8 py-6">
                @csrf
                @method('PUT')

                <!-- Avatar Upload -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Profil Fotoğrafı</label>
                    <div class="flex items-center gap-6">
                        <img src="{{ $profile->avatar_path ? Storage::url($profile->avatar_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=128&background=6366f1&color=fff' }}" 
                             alt="{{ $user->name }}" 
                             class="w-24 h-24 rounded-full border-2 border-gray-200 dark:border-gray-600">
                        <div>
                            <input type="file" name="avatar" id="avatar" accept="image/*" 
                                   class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 dark:file:bg-indigo-900 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800">
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF en fazla 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="headline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Başlık</label>
                        <input type="text" name="headline" id="headline" value="{{ old('headline', $profile->headline) }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="ör. Laravel Geliştirici" maxlength="120">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ strlen($profile->headline ?? '') }}/120 karakter</p>
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Şehir</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $profile->city) }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Şehriniz">
                    </div>

                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ülke</label>
                        <input type="text" name="country" id="country" value="{{ old('country', $profile->country) }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Ülkeniz">
                    </div>

                    <div>
                        <label for="website_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Web Sitesi</label>
                        <input type="url" name="website_url" id="website_url" value="{{ old('website_url', $profile->website_url) }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://yoursite.com">
                    </div>
                </div>

                <!-- Bio -->
                <div class="mb-8">
                    <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Biyografi</label>
                    <textarea name="bio" id="bio" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Kendinizden bahsedin..." maxlength="2000">{{ old('bio', $profile->bio) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ strlen($profile->bio ?? '') }}/2000 karakter</p>
                </div>

                <!-- Skills -->
                <div class="mb-8">
                    <label for="skills" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yetenekler</label>
                    <input type="text" name="skills" id="skills" value="{{ old('skills', implode(', ', $profile->skills ?? [])) }}" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Laravel, PHP, JavaScript, Vue.js">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Yetenekleri virgülle ayırın</p>
                </div>

                <!-- Social Links -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">LinkedIn</label>
                        <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://linkedin.com/in/username">
                    </div>

                    <div>
                        <label for="github_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GitHub</label>
                        <input type="url" name="github_url" id="github_url" value="{{ old('github_url', $profile->github_url) }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://github.com/username">
                    </div>

                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Instagram</label>
                        <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://instagram.com/username">
                    </div>

                    <div>
                        <label for="youtube_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">YouTube</label>
                        <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $profile->youtube_url) }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://youtube.com/channel/username">
                    </div>

                    <div>
                        <label for="x_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">X (Twitter)</label>
                        <input type="url" name="x_url" id="x_url" value="{{ old('x_url', $profile->x_url) }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://twitter.com/username">
                    </div>

                    <div>
                        <label for="behance_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Behance</label>
                        <input type="url" name="behance_url" id="behance_url" value="{{ old('behance_url', $profile->behance_url) }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://behance.net/username">
                    </div>

                    <div>
                        <label for="dribbble_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dribbble</label>
                        <input type="url" name="dribbble_url" id="dribbble_url" value="{{ old('dribbble_url', $profile->dribbble_url) }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               placeholder="https://dribbble.com/username">
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Profil Görünürlüğü</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Profilinizi diğer kullanıcılar için görünür yapın</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_public" id="is_public" value="1" 
                                   class="sr-only peer" {{ old('is_public', $profile->is_public) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                        Değişiklikleri Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Character counter for bio and headline
document.getElementById('headline').addEventListener('input', function() {
    const counter = this.nextElementSibling;
    counter.textContent = this.value.length + '/120 karakter';
});

document.getElementById('bio').addEventListener('input', function() {
    const counter = this.nextElementSibling;
    counter.textContent = this.value.length + '/2000 karakter';
});
</script>
@endsection