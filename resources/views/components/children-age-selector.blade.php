@props(['maxChildren' => 4])

<div x-data="childrenAgeSelector({{ $maxChildren }})" class="space-y-4">
    <!-- Number of Children -->
    <div>
        <label for="children_count" class="block text-sm font-medium text-gray-700 mb-1">
            Nombre d'enfants (0-12 ans)
        </label>
        <select x-model="childrenCount" @change="updateChildren()"
                id="children_count" name="children_count"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="0">Aucun enfant</option>
            @for($i = 1; $i <= $maxChildren; $i++)
                <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'enfant' : 'enfants' }}</option>
            @endfor
        </select>
    </div>

    <!-- Children Ages -->
    <div x-show="childrenCount > 0" x-cloak class="space-y-3">
        <p class="text-sm text-gray-600">Âge de chaque enfant au moment du voyage:</p>
        <template x-for="(child, index) in children" :key="index">
            <div class="flex items-center gap-3">
                <label :for="'child_age_' + index" class="text-sm font-medium text-gray-700 w-24">
                    Enfant <span x-text="index + 1"></span>:
                </label>
                <select :id="'child_age_' + index" :name="'children_ages[' + index + ']'"
                        x-model="children[index]" required
                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Sélectionnez l'âge</option>
                    <option value="0">&lt; 1 an</option>
                    @for($age = 1; $age <= 12; $age++)
                        <option value="{{ $age }}">{{ $age }} {{ $age === 1 ? 'an' : 'ans' }}</option>
                    @endfor
                </select>
                <div class="text-xs text-gray-500 w-32">
                    <template x-if="children[index] >= 0 && children[index] <= 2">
                        <span class="text-blue-600">Bébé/Nourrisson</span>
                    </template>
                    <template x-if="children[index] >= 3 && children[index] <= 11">
                        <span class="text-green-600">Enfant</span>
                    </template>
                    <template x-if="children[index] == 12">
                        <span class="text-orange-600">Pré-adolescent</span>
                    </template>
                </div>
            </div>
        </template>

        <!-- Summary -->
        <div class="bg-blue-50 border border-blue-200 rounded-md p-3 mt-4">
            <p class="text-sm text-blue-800">
                <strong>Récapitulatif:</strong>
                <template x-if="getSummary().infants > 0">
                    <span x-text="getSummary().infants + ' bébé(s)'"></span>
                </template>
                <template x-if="getSummary().children > 0">
                    <span x-text="(getSummary().infants > 0 ? ', ' : '') + getSummary().children + ' enfant(s)'"></span>
                </template>
                <template x-if="getSummary().preteens > 0">
                    <span x-text="(getSummary().infants > 0 || getSummary().children > 0 ? ', ' : '') + getSummary().preteens + ' pré-ado(s)'"></span>
                </template>
            </p>
            <p class="text-xs text-blue-600 mt-1">
                Les tarifs peuvent varier selon l'âge des enfants.
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('childrenAgeSelector', (maxChildren) => ({
            childrenCount: 0,
            children: [],

            updateChildren() {
                const count = parseInt(this.childrenCount);

                // Keep existing ages when increasing count
                while (this.children.length < count) {
                    this.children.push('');
                }

                // Remove excess when decreasing count
                while (this.children.length > count) {
                    this.children.pop();
                }
            },

            getSummary() {
                let infants = 0;  // 0-2 years
                let children = 0; // 3-11 years
                let preteens = 0; // 12 years

                this.children.forEach(age => {
                    const ageNum = parseInt(age);
                    if (ageNum >= 0 && ageNum <= 2) {
                        infants++;
                    } else if (ageNum >= 3 && ageNum <= 11) {
                        children++;
                    } else if (ageNum === 12) {
                        preteens++;
                    }
                });

                return { infants, children, preteens };
            }
        }));
    });
</script>
