<div class="bg-gradient-to-r from-blue-600 to-purple-600 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
            <!-- Content -->
            <div class="text-white lg:w-1/2">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                    Recevez nos meilleures offres
                </h2>
                <p class="text-lg text-blue-100 mb-2">
                    Inscrivez-vous à notre newsletter et ne manquez aucune promotion!
                </p>
                <ul class="space-y-2 text-blue-100">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Offres exclusives jusqu'à -50%
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Conseils voyage et guides gratuits
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Nouveautés et destinations tendances
                    </li>
                </ul>
            </div>

            <!-- Form -->
            <div class="lg:w-1/2 w-full">
                <form action="#" method="POST" class="bg-white rounded-xl shadow-2xl p-8">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="newsletter_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Prénom
                            </label>
                            <input type="text"
                                   id="newsletter_name"
                                   name="name"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Votre prénom">
                        </div>

                        <div>
                            <label for="newsletter_email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <input type="email"
                                   id="newsletter_email"
                                   name="email"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="votre@email.com">
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox"
                                       id="newsletter_consent"
                                       name="consent"
                                       required
                                       class="w-4 h-4 border border-gray-300 rounded bg-white focus:ring-2 focus:ring-blue-500">
                            </div>
                            <label for="newsletter_consent" class="ml-2 text-xs text-gray-600">
                                J'accepte de recevoir des emails promotionnels. Vous pouvez vous désabonner à tout moment.
                            </label>
                        </div>

                        <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                            S'inscrire maintenant
                        </button>
                    </div>

                    <p class="mt-4 text-xs text-center text-gray-500">
                        🔒 Vos données sont protégées et ne seront jamais partagées
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
