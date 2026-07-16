<script>
    import { Slide, Transition, Code } from '@animotion/core';
    import { codeTheme, codeOptions } from './code.js';

    const createTable = `CREATE TABLE orders (
  id         INT,
  customer   VARCHAR(50),
  status     VARCHAR(20),
  amount     DECIMAL(10,2)
);`;

    const selectQuery = `SELECT id, amount
FROM orders
WHERE status = 'shipped'
ORDER BY amount DESC;`;

    const createView = `CREATE VIEW revenue_by_country AS
  SELECT 
    country, 
    SUM(amount) AS revenue
  FROM orders
  GROUP BY country;`;

    const selectView = `SELECT country, revenue
FROM revenue_by_country
WHERE revenue > 5000
ORDER BY revenue DESC;`;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="mb-6 text-center text-5xl font-black tracking-tight">
            Table vs <span class="text-red-500">View</span>
        </p>
    </Transition>

    <div class="grid w-full max-w-6xl grid-cols-2 gap-8">
        <!-- LEFT: raw table -->
        <div class="flex flex-col gap-4">
            <Transition>
                <p
                    class="text-lg font-light tracking-widest text-white/40 uppercase"
                >
                    A table
                </p>
            </Transition>

            <Transition
                class="text-md rounded-xl border border-white/10 bg-white/3 px-5 py-4"
            >
                <Code
                    lang="sql"
                    theme={codeTheme}
                    code={createTable}
                    options={codeOptions}
                />
            </Transition>

            <Transition>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-white/40">
                            <th class="pr-4 pb-1 font-normal">id</th>
                            <th class="pr-4 pb-1 font-normal">customer</th>
                            <th class="pr-4 pb-1 font-normal">status</th>
                            <th class="pb-1 font-normal">amount</th>
                        </tr>
                    </thead>
                    <tbody class="font-mono text-white/70">
                        <tr class="border-b border-white/5">
                            <td class="py-1 pr-4">1</td>
                            <td class="py-1 pr-4">alice</td>
                            <td class="py-1 pr-4">shipped</td>
                            <td class="py-1">120.00</td>
                        </tr>
                        <tr class="border-b border-white/5">
                            <td class="py-1 pr-4">2</td>
                            <td class="py-1 pr-4">bob</td>
                            <td class="py-1 pr-4">pending</td>
                            <td class="py-1">45.50</td>
                        </tr>
                        <tr>
                            <td class="py-1 pr-4">3</td>
                            <td class="py-1 pr-4">alice</td>
                            <td class="py-1 pr-4">shipped</td>
                            <td class="py-1">200.00</td>
                        </tr>
                    </tbody>
                </table>
            </Transition>

            <Transition
                class="rounded-xl border border-white/10 bg-white/3 px-5 py-4"
            >
                <Code
                    lang="sql"
                    theme={codeTheme}
                    code={selectQuery}
                    options={codeOptions}
                />
            </Transition>
        </div>

        <!-- RIGHT: view — standalone entity -->
        <div class="flex flex-col gap-4">
            <Transition>
                <p
                    class="text-lg font-light tracking-widest text-red-400/70 uppercase"
                >
                    A view — defined once
                </p>
            </Transition>

            <Transition
                class="rounded-xl border border-red-500/20 bg-red-500/3 px-5 py-4 text-xl"
            >
                <Code
                    lang="sql"
                    theme={codeTheme}
                    code={createView}
                    options={codeOptions}
                    c
                />
            </Transition>

            <Transition>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-white/10 text-white/40">
                            <th class="pr-4 pb-1 font-normal">country</th>
                            <th class="pb-1 font-normal">revenue</th>
                        </tr>
                    </thead>
                    <tbody class="font-mono text-white/70">
                        <tr class="border-b border-white/5">
                            <td class="py-1 pr-4">FR</td>
                            <td class="py-1">8 420.00</td>
                        </tr>
                        <tr class="border-b border-white/5">
                            <td class="py-1 pr-4">JP</td>
                            <td class="py-1">5 110.00</td>
                        </tr>
                        <tr>
                            <td class="py-1 pr-4">US</td>
                            <td class="py-1">3 890.00</td>
                        </tr>
                    </tbody>
                </table>
            </Transition>

            <Transition
                class="rounded-xl border border-red-500/20 bg-red-500/3 px-5 py-4"
            >
                <Code
                    lang="sql"
                    theme={codeTheme}
                    code={selectView}
                    options={codeOptions}
                />
            </Transition>
        </div>
    </div>
</Slide>
