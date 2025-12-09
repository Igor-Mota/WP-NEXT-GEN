<div 
    x-data="{ 
        currentGradient: 'blueGreen', 
        gradients: {
            blueGreen: 'background-image: linear-gradient(135deg, #36a4e3 0%, #38d39f 100%)',
            redYellow: 'background-image: linear-gradient(135deg, #f05053 0%, #f6ce40 100%)',
            purplePink: 'background-image: linear-gradient(135deg, #9333ea 0%, #ec4899 100%)',
            yellowOrange: 'background-image: linear-gradient(135deg, #fbbf24 0%, #f97316 100%)',
            emeraldTeal: 'background-image: linear-gradient(135deg, #059669 0%, #14b8a6 100%)',
            greyBlue: 'background-image: linear-gradient(135deg, #94a3b8 0%, #3b82f6 100%)'
        },
        contentVisible: true, 
        isTextRed: false,
        fontSize: 18,
        currentGradient:'blueGreen',
        oldGradient:'blueGreen',
        isFading:false
    }"
    x-effect="
        if (currentGradient !== oldGradient && !isFading) {
            isFading = true;
            // Aguarda o tempo da transição de opacidade (500ms)
            setTimeout(() => {
                oldGradient = currentGradient;
                isFading = false;
            }, 500);
        }
    "
    :style="gradients[currentGradient]"
    {{-- Transição da Seção: O tempo de 500ms aqui é essencial para o fundo (background-color) e outros elementos. --}}
    class="min-h-screen flex items-center justify-center relative overflow-hidden text-white py-16 sm:py-20 transition-all duration-500 ease-in-out" 
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10 w-full">
        
        <div class="grid grid-cols-1 gap-12 items-center md:grid-cols-2">
            
   
            <div class="text-white text-center md:text-left">
                <p class="text-lg font-semibold mb-2">WP NEXT GEN</p>
                <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight">
                    VEJA O POWER DA INTERATIVIDADE
                </h2>
                <p class="mt-4 text-xl sm:text-2xl font-light">
                    Controle elementos da página com <span class="font-bold">Alpine.js</span>
                </p>
            </div>


            <div 
                class="p-6 sm:p-8 rounded-2xl shadow-2xl bg-teal-500 bg-opacity-70 backdrop-blur-md"
                style="background-color: #31c48d; background-image: linear-gradient(135deg, #31c48d 0%, #177363 100%);"
            >

                <h3 class="text-white text-xl sm:text-2xl font-bold mb-6">Controles Alpine.js</h3>
                

                <div class="mb-6 border-b border-white/20 pb-4">
                    <label class="block text-white font-semibold mb-2 text-sm sm:text-base">Mudar Gradiente da Seção</label>

                    {{-- Botões de Gradiente: Aumentado para duration-500 no ring/hover --}}
                    <div class="flex space-x-3 mb-3">
                         <button 
                            x-on:click="currentGradient = 'blueGreen'"
                            :class="currentGradient === 'blueGreen' ? 'ring-4 ring-white/70' : 'hover:ring-2 ring-white/50'"
                            class="flex-1 h-10 rounded-xl transition-all duration-500 ease-in-out"
                            style="background-image: linear-gradient(135deg, #36a4e3 0%, #38d39f 100%);"
                        ></button>
                        <button 
                            x-on:click="currentGradient = 'redYellow'"
                            :class="currentGradient === 'redYellow' ? 'ring-4 ring-white/70' : 'hover:ring-2 ring-white/50'"
                            class="flex-1 h-10 rounded-xl transition-all duration-500 ease-in-out"
                            style="background-image: linear-gradient(135deg, #f05053 0%, #f6ce40 100%);"
                        ></button>
                         <button 
                            x-on:click="currentGradient = 'purplePink'"
                            :class="currentGradient === 'purplePink' ? 'ring-4 ring-white/70' : 'hover:ring-2 ring-white/50'"
                            class="flex-1 h-10 rounded-xl transition-all duration-500 ease-in-out"
                            style="background-image: linear-gradient(135deg, #9333ea 0%, #ec4899 100%);"
                        ></button>
                    </div>
                    
                    {{-- SEGUNDA LINHA DE BOTÕES: Aumentado para duration-500 no ring/hover --}}
                    <div class="flex space-x-3">
                        <button 
                            x-on:click="currentGradient = 'yellowOrange'"
                            :class="currentGradient === 'yellowOrange' ? 'ring-4 ring-white/70' : 'hover:ring-2 ring-white/50'"
                            class="flex-1 h-10 rounded-xl transition-all duration-500 ease-in-out"
                            style="background-image: linear-gradient(135deg, #fbbf24 0%, #f97316 100%);"
                        ></button>
                        <button 
                            x-on:click="currentGradient = 'emeraldTeal'"
                            :class="currentGradient === 'emeraldTeal' ? 'ring-4 ring-white/70' : 'hover:ring-2 ring-white/50'"
                            class="flex-1 h-10 rounded-xl transition-all duration-500 ease-in-out"
                            style="background-image: linear-gradient(135deg, #059669 0%, #14b8a6 100%);"
                        ></button>
                        <button 
                            x-on:click="currentGradient = 'greyBlue'"
                            :class="currentGradient === 'greyBlue' ? 'ring-4 ring-white/70' : 'hover:ring-2 ring-white/50'"
                            class="flex-1 h-10 rounded-xl transition-all duration-500 ease-in-out"
                            style="background-image: linear-gradient(135deg, #94a3b8 0%, #3b82f6 100%);"
                        ></button>
                    </div>
                </div>


                <div class="mb-6 border-b border-white/20 pb-4">
                    <button 
                        x-on:click="contentVisible = !contentVisible"
                        {{-- Botão de Ação: Aumentado para duration-500 --}}
                        class="w-full text-white font-semibold py-3 px-4 rounded-xl transition duration-500 ease-in-out text-sm sm:text-base"
                        :class="contentVisible ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-green-600 hover:bg-green-700'"
                    >
                        <span x-text="contentVisible ? 'Ocultar Conteúdo' : 'Mostrar Conteúdo'"></span>
                    </button>
                    
                    {{-- A transição do x-show é controlada pelo Alpine.js (500ms) --}}
                    <div x-show.transition.duration.500ms="contentVisible" class="mt-4 p-4 rounded-lg bg-white/10 text-white flex items-center justify-between">
                        <p class="font-medium text-sm sm:text-base">
                            Conteudo ajustavel
                        </p>
                        <svg class="w-8 h-8 ml-4 text-white hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L13 7h4.25a.75.75 0 010 1.5H13l-3.25 10.5a.75.75 0 01-1.46-1.5L10 17zM9.75 17L6.5 7h-4.25a.75.75 0 010 1.5h3.25l3.25 10.5a.75.75 0 011.46-1.5zM12 4h.01"></path></svg>
                    </div>
                </div>

                <div class="mb-6 border-b border-white/20 pb-4">
                    <button 
                        x-on:click="isTextRed = !isTextRed"
                        class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-4 rounded-xl transition duration-500 ease-in-out text-sm sm:text-base"
                    >
                        Mudar Cor de Texto
                    </button>
                    <p class="mt-3 text-sm sm:text-base font-medium transition-colors duration-500 ease-in-out" 
                       :class="isTextRed ? 'text-red-300' : 'text-white'"
                    >
                        O texto de feedback muda de cor!
                    </p>
                </div>

                <div class="mb-6">
                    <label class="block text-white font-semibold mb-2 text-sm sm:text-base">
                        Aumentar/Diminuir Fonte (<span x-text="fontSize + 'px'"></span>)
                    </label>
                    <input 
                        type="range" 
                        min="12" 
                        max="24" 
                        step="1" 
                        x-model="fontSize" 
                        class="w-full h-2 bg-white/30 rounded-lg appearance-none cursor-pointer range-lg"
                    >
                    <p class="mt-3 text-sm sm:text-base text-white transition-all duration-100 ease-linear" 
                       :style="`font-size: ${fontSize}px;`"
                    >
                       Tamanho da fonte ajustável em tempo real.
                    </p>
                </div>

            </div>
        </div>
        
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-12">
    @php
        $features = [
            [
                'label' => 'Tempo Real', 
                'icon' => '<svg class="w-8 h-8 sm:w-10 sm:h-10 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                'text' => 'Atualizações instantâneas e sem recarregamento de página. Performance não é opcional, é padrão.'
            ],
            [
                'label' => 'Fácil de Usar', 
                'icon' => '<svg class="w-8 h-8 sm:w-10 sm:h-10 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.27a11.957 11.957 0 011.08 4.27m-1.08-4.27h-2.261l-.64-1.353a4.001 4.001 0 00-3.377-2.316h-4.66a4.001 4.001 0 00-3.377 2.316l-.64 1.353H4.382m8.618-4.27a11.957 11.957 0 011.08 4.27m-1.08-4.27h-2.261l-.64-1.353a4.001 4.001 0 00-3.377-2.316h-4.66a4.001 4.001 0 00-3.377 2.316l-.64 1.353H4.382"></path></svg>',
                'text' => 'Interfaces intuitivas e zero curva de aprendizado. Gaste menos tempo configurando e mais tempo criando.'
            ],
            [
                'label' => 'Performance', 
                'icon' => '<svg class="w-8 h-8 sm:w-10 sm:h-10 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>',
                'text' => 'Arquitetura com Code Splitting. Seus usuários só carregam o código que realmente precisam em cada página.'
            ]
        ];
    @endphp

    @foreach ($features as $feature)
        <div class="
            bg-white/20 backdrop-blur-sm rounded-xl p-6 
            text-white transition-all duration-500 ease-out cursor-pointer 
            hover:bg-white/30 hover:shadow-2xl hover:scale-[1.03]
        ">
            <div class="flex items-center space-x-2">
                {!! $feature['icon'] !!}
            </div>
            
            <h4 class="text-xl font-bold mt-2 mb-1">
                {{ $feature['label'] }}
            </h4>

            <p class="text-sm font-light opacity-80">
                {{ $feature['text'] }}
            </p>
        </div>
    @endforeach
</div>

    </div>
</div>