<?php

namespace Database\Seeders;

use App\Models\ClassLevel;
use App\Models\Resource;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with realistic Ugandan
     * New Lower Secondary Curriculum data.
     */
    public function run(): void
    {
        // ------------------------------------------------------------------ //
        //  DEFAULT LIBRARIAN ACCOUNT
        // ------------------------------------------------------------------ //
        User::firstOrCreate(
            ['email' => 'librarian@mengo.sc.ug'],
            [
                'name'     => 'Mengo Library Admin',
                'password' => Hash::make('password123'),
                'role'     => 'librarian',
            ]
        );

        // ------------------------------------------------------------------ //
        //  CLASS LEVELS  (Uganda Lower Secondary = S1 – S4)
        // ------------------------------------------------------------------ //
        $levels = [
            [
                'name'        => 'Senior One',
                'description' => 'The entry level of Uganda\'s New Lower Secondary Curriculum (NLSC). '
                               . 'Learners build foundational competencies across all subject areas.',
            ],
            [
                'name'        => 'Senior Two',
                'description' => 'Learners deepen understanding of core concepts and begin applying '
                               . 'knowledge to real-world problems in the Ugandan context.',
            ],
            [
                'name'        => 'Senior Three',
                'description' => 'Advanced exploration of subjects with emphasis on critical thinking, '
                               . 'research skills, and integration of knowledge.',
            ],
            [
                'name'        => 'Senior Four',
                'description' => 'The terminal year of lower secondary. Learners prepare for Uganda '
                               . 'Certificate of Education (UCE) examinations.',
            ],
        ];

        foreach ($levels as $levelData) {
            ClassLevel::firstOrCreate(['name' => $levelData['name']], $levelData);
        }

        $s1 = ClassLevel::where('name', 'Senior One')->first();
        $s2 = ClassLevel::where('name', 'Senior Two')->first();
        $s3 = ClassLevel::where('name', 'Senior Three')->first();
        $s4 = ClassLevel::where('name', 'Senior Four')->first();

        // ------------------------------------------------------------------ //
        //  CURRICULUM DATA  (per class level)
        // ------------------------------------------------------------------ //

        $curriculum = [

            // ============================  SENIOR ONE  ============================ //
            $s1->id => [
                [
                    'name' => 'Mathematics',
                    'code' => 'MTH-S1',
                    'topics' => [
                        [
                            'title' => 'Set Theory',
                            'competency_description' =>
                                'By the end of this topic the learner should be able to define sets, '
                                . 'identify elements, describe relationships between sets using Venn diagrams, '
                                . 'and apply set operations (union, intersection, complement) to solve real-life problems.',
                            'resources' => [
                                [
                                    'title'         => 'Introduction to Sets – Khan Academy',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.khanacademy.org/math/cc-sixth-grade-math/cc-6th-factors-and-multiples/cc-6th-set-theory/a/set-theory',
                                    'annotation'    => 'Clear text and interactive exercises covering the definition of sets, '
                                                     . 'subsets, union and intersection. Suitable for S1 beginners. '
                                                     . 'Exercises auto-grade so students get instant feedback.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Venn Diagrams Explained – YouTube (MathsOnline)',
                                    'resource_type' => 'Video',
                                    'url'           => 'https://www.youtube.com/watch?v=sdflTT5Ds3Y',
                                    'annotation'    => 'A 12-minute video walking through two- and three-set Venn diagrams '
                                                     . 'with shaded regions. Highly visual – recommended for visual learners.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Sets & Venn Diagrams – PhET Interactive Simulation',
                                    'resource_type' => 'Simulation',
                                    'url'           => 'https://phet.colorado.edu/en/simulations/plinko-probability',
                                    'annotation'    => 'Interactive tool allowing students to drag elements between sets '
                                                     . 'and observe how union/intersection regions change dynamically.',
                                    'is_verified'   => false,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Algebra & Linear Equations',
                            'competency_description' =>
                                'The learner should be able to form and solve linear equations and inequalities in one '
                                . 'variable, interpret solutions graphically, and apply algebra to practical situations '
                                . 'such as calculating costs, distances, and ages.',
                            'resources' => [
                                [
                                    'title'         => 'Solving Linear Equations – Khan Academy Practice',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.khanacademy.org/math/algebra/x2f8bb11595b61c86:solve-equations-inequalities',
                                    'annotation'    => 'Comprehensive unit with video lessons and graded exercises. '
                                                     . 'Covers one-step, two-step, and multi-step equations. '
                                                     . 'Progress tracking available if students create a free account.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Algebra Basics Full Course – Organic Chemistry Tutor (YouTube)',
                                    'resource_type' => 'Video',
                                    'url'           => 'https://www.youtube.com/watch?v=NybHckSEQBI',
                                    'annotation'    => 'A 47-minute comprehensive algebra walkthrough. Particularly useful '
                                                     . 'for students who prefer long-form explanations before practising.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Statistics & Data Handling',
                            'competency_description' =>
                                'Learners should collect, organise, represent and interpret data using frequency tables, '
                                . 'bar charts, pie charts and line graphs. They should calculate mean, median, and mode '
                                . 'and draw conclusions from statistical data.',
                            'resources' => [
                                [
                                    'title'         => 'Statistics & Probability – BBC Bitesize',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.bbc.co.uk/bitesize/topics/z4sfr82',
                                    'annotation'    => 'Well-structured British curriculum resource that maps closely to the '
                                                     . 'Uganda NLSC statistics strand. Contains revision cards and quizzes.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Mean, Median & Mode – Desmos Classroom Activity',
                                    'resource_type' => 'Simulation',
                                    'url'           => 'https://teacher.desmos.com/activitybuilder/custom/5a4b90d0a78c6c3acb15e58e',
                                    'annotation'    => 'Students input their own data and Desmos renders charts in real time. '
                                                     . 'Excellent for understanding how outliers affect averages.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Biology',
                    'code' => 'BIO-S1',
                    'topics' => [
                        [
                            'title' => 'Cell Biology',
                            'competency_description' =>
                                'By the end of this topic learners should identify and describe the structure and function '
                                . 'of plant and animal cells, distinguish prokaryotic from eukaryotic cells, '
                                . 'and relate cell organelles to the seven characteristics of living things.',
                            'resources' => [
                                [
                                    'title'         => 'Cell Structure & Function – CrashCourse Biology #5',
                                    'resource_type' => 'Video',
                                    'url'           => 'https://www.youtube.com/watch?v=URUJD5NEXC8',
                                    'annotation'    => 'Engaging 12-minute crash course covering organelles in both plant '
                                                     . 'and animal cells. Diagrams are clear. Ideal for introducing '
                                                     . 'the topic before a practical microscopy session.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Animal vs Plant Cell Interactive Diagram – Biology Corner',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.biologycorner.com/worksheets/cellvirtual.html',
                                    'annotation'    => 'Click-through labelling activity. Students click on each organelle '
                                                     . 'to read its function. Great pre-test revision tool.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Cell Explorer 3D Simulation – Cells Alive',
                                    'resource_type' => 'Simulation',
                                    'url'           => 'https://www.cellsalive.com/cells/cell_model.htm',
                                    'annotation'    => 'Rotating 3D cell model in browser. Students can toggle organelles '
                                                     . 'on/off and read descriptions. Works offline after initial load.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Photosynthesis & Respiration',
                            'competency_description' =>
                                'Learners should be able to write the balanced equations for photosynthesis and aerobic '
                                . 'respiration, identify the raw materials, products, and site of each process, '
                                . 'and investigate factors affecting the rate of photosynthesis experimentally.',
                            'resources' => [
                                [
                                    'title'         => 'Photosynthesis – Khan Academy Unit',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.khanacademy.org/science/ap-biology/cellular-energetics/photosynthesis/a/intro-to-photosynthesis',
                                    'annotation'    => 'Detailed article with diagrams covering the light-dependent and '
                                                     . 'light-independent reactions. Follow-up quiz available. '
                                                     . 'Recommended as reading homework.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'PhET: Photosynthesis Simulation',
                                    'resource_type' => 'Simulation',
                                    'url'           => 'https://phet.colorado.edu/en/simulations/sugar-and-salt-solutions',
                                    'annotation'    => 'Adjust light intensity, CO₂ concentration and temperature to observe '
                                                     . 'effects on oxygen production. Encourages scientific inquiry skills.',
                                    'is_verified'   => false,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Geography',
                    'code' => 'GEO-S1',
                    'topics' => [
                        [
                            'title' => 'Map Reading & Interpretation',
                            'competency_description' =>
                                'Learners should be able to read and interpret topographic maps, use grid references, '
                                . 'calculate distances and areas using scale, and identify relief features from contour lines.',
                            'resources' => [
                                [
                                    'title'         => 'Uganda Topographic Maps – Uganda Lands & Surveys',
                                    'resource_type' => 'PDF',
                                    'url'           => 'https://www.maphill.com/uganda/maps/',
                                    'annotation'    => 'Official Uganda mapping resource. Explore 1:50,000 scale maps of '
                                                     . 'regions around Kampala, Entebbe, and Jinja for local context exercises.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Contour Lines & Relief Features – YouTube (GeoBytes)',
                                    'resource_type' => 'Video',
                                    'url'           => 'https://www.youtube.com/watch?v=CoVcRxza8nI',
                                    'annotation'    => 'Animated video explaining how contour lines show elevation changes. '
                                                     . 'Good visual explanation of V-shaped valleys, ridges, and spurs.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Google Earth – East Africa Map Exploration',
                                    'resource_type' => 'Simulation',
                                    'url'           => 'https://earth.google.com/web/@0.316,32.583,1200a,200000d',
                                    'annotation'    => 'Live satellite view centred on Uganda. Students can identify '
                                                     . 'physical features: Lake Victoria, River Nile, the Rwenzori Mountains. '
                                                     . 'Requires internet access.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Climate & Weather of Uganda',
                            'competency_description' =>
                                'Learners should explain the factors influencing Uganda\'s climate, distinguish between '
                                . 'weather and climate, interpret climate graphs, and relate climate to human activities '
                                . 'such as farming and tourism.',
                            'resources' => [
                                [
                                    'title'         => 'Uganda Climate Overview – World Bank Climate Portal',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://climateknowledgeportal.worldbank.org/country/uganda/climate-data-historical',
                                    'annotation'    => 'Official climate data with monthly temperature and rainfall graphs for '
                                                     . 'different Ugandan districts. Excellent primary data source for '
                                                     . 'geography investigations.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'English Language',
                    'code' => 'ENG-S1',
                    'topics' => [
                        [
                            'title' => 'Reading Comprehension Strategies',
                            'competency_description' =>
                                'By the end of this topic, learners will apply reading strategies including skimming, '
                                . 'scanning, inferencing, and summarising to comprehend a range of academic and '
                                . 'literary texts appropriate to Senior One level.',
                            'resources' => [
                                [
                                    'title'         => 'Reading Strategies Toolkit – ReadWriteThink',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.readwritethink.org/classroom-resources/lesson-plans/comprehension-strategies-toolkit',
                                    'annotation'    => 'A librarian-curated toolkit with printable strategy guides. '
                                                     . 'Recommended for classroom use alongside any prescribed text.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // ============================  SENIOR TWO  ============================ //
            $s2->id => [
                [
                    'name' => 'Mathematics',
                    'code' => 'MTH-S2',
                    'topics' => [
                        [
                            'title' => 'Trigonometry',
                            'competency_description' =>
                                'Learners should define the trigonometric ratios (sine, cosine, tangent) in right-angled '
                                . 'triangles, use trigonometric tables and calculators, and apply trigonometry to find '
                                . 'angles of elevation and depression in real-life measurement problems.',
                            'resources' => [
                                [
                                    'title'         => 'Trigonometry Full Unit – Khan Academy',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.khanacademy.org/math/trigonometry',
                                    'annotation'    => 'A complete unit from ratio definitions to graphs. Exercises '
                                                     . 'progress in difficulty. Students can bookmark their progress.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'SOH-CAH-TOA Explained Simply – YouTube',
                                    'resource_type' => 'Video',
                                    'url'           => 'https://www.youtube.com/watch?v=F21S9Wpi0y8',
                                    'annotation'    => 'A beginner-friendly mnemonic walkthrough. Best watched before '
                                                     . 'attempting Khan Academy exercises.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Desmos Graphing Calculator – Trig Functions',
                                    'resource_type' => 'Simulation',
                                    'url'           => 'https://www.desmos.com/calculator',
                                    'annotation'    => 'Free online graphing tool. Students can plot y=sin(x), y=cos(x) '
                                                     . 'and observe transformations interactively. Works on any browser.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Quadratic Equations',
                            'competency_description' =>
                                'By the end of this topic learners should solve quadratic equations by factorisation, '
                                . 'completing the square, and the quadratic formula. They should also sketch parabolas '
                                . 'and interpret the discriminant.',
                            'resources' => [
                                [
                                    'title'         => 'Quadratics – Factorising & Formula (BBC Bitesize GCSE)',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.bbc.co.uk/bitesize/topics/zqvv4wx',
                                    'annotation'    => 'Structured revision pages with worked examples and self-test quizzes. '
                                                     . 'The content level aligns well with UNEB S2 expectations.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Chemistry',
                    'code' => 'CHM-S2',
                    'topics' => [
                        [
                            'title' => 'Acids, Bases & Salts',
                            'competency_description' =>
                                'Learners should identify acidic and basic substances by pH, conduct neutralisation '
                                . 'reactions, prepare salts by different methods, and relate the properties of acids, '
                                . 'bases and salts to everyday materials in Uganda.',
                            'resources' => [
                                [
                                    'title'         => 'Acids & Bases – Khan Academy',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.khanacademy.org/science/chemistry/acids-and-bases-topic',
                                    'annotation'    => 'Covers Arrhenius, Brønsted-Lowry definitions, pH scale, '
                                                     . 'and neutralisation with worked examples.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'PhET: Acid-Base Solutions Simulation',
                                    'resource_type' => 'Simulation',
                                    'url'           => 'https://phet.colorado.edu/en/simulations/acid-base-solutions',
                                    'annotation'    => 'Directly relevant simulation. Students choose acids or bases, '
                                                     . 'adjust concentration, and observe pH meter and conductivity changes. '
                                                     . 'Verified by the librarian as curriculum-aligned.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Making Salts – Royal Society of Chemistry',
                                    'resource_type' => 'PDF',
                                    'url'           => 'https://edu.rsc.org/resources/making-salts/1882.article',
                                    'annotation'    => 'Downloadable practical guide with safety notes and result tables. '
                                                     . 'Useful for setting up lab work or for students to follow along at home.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Atomic Structure & Periodic Table',
                            'competency_description' =>
                                'Learners should describe the structure of atoms (protons, neutrons, electrons), '
                                . 'understand atomic number and mass number, explain isotopes, and use the periodic '
                                . 'table to predict element properties and group trends.',
                            'resources' => [
                                [
                                    'title'         => 'Atomic Structure – CrashCourse Chemistry #1',
                                    'resource_type' => 'Video',
                                    'url'           => 'https://www.youtube.com/watch?v=FSyAehMdpyI',
                                    'annotation'    => 'Fast-paced but comprehensive 12-minute overview. '
                                                     . 'Recommended as a lesson starter or revision video.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Interactive Periodic Table – Royal Society of Chemistry',
                                    'resource_type' => 'Simulation',
                                    'url'           => 'https://www.rsc.org/periodic-table',
                                    'annotation'    => 'Click any element for detailed data including history, uses, '
                                                     . 'and electron configuration. Excellent research reference.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Physics',
                    'code' => 'PHY-S2',
                    'topics' => [
                        [
                            'title' => 'Newton\'s Laws of Motion',
                            'competency_description' =>
                                'Learners should state and apply Newton\'s three laws of motion, calculate resultant forces, '
                                . 'solve problems involving mass, acceleration, weight, friction, and apply F=ma '
                                . 'to transport scenarios relevant to Ugandan road safety.',
                            'resources' => [
                                [
                                    'title'         => 'Newton\'s Laws – PhET Forces & Motion Simulation',
                                    'resource_type' => 'Simulation',
                                    'url'           => 'https://phet.colorado.edu/en/simulations/forces-and-motion-basics',
                                    'annotation'    => 'Highly recommended. Students apply forces to objects and observe '
                                                     . 'acceleration, friction, and net force in real time. '
                                                     . 'Available offline after download.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Newton\'s Laws Explained – MinutePhysics',
                                    'resource_type' => 'Video',
                                    'url'           => 'https://www.youtube.com/watch?v=kKKM8Y-u7ds',
                                    'annotation'    => 'Concise animated explainer. Very good for conceptual understanding '
                                                     . 'before calculation exercises.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Forces Worksheet Pack – Physics Classroom',
                                    'resource_type' => 'PDF',
                                    'url'           => 'https://www.physicsclassroom.com/calcpad/Forces',
                                    'annotation'    => 'Printable calculation practice sheets. Suitable for supervised '
                                                     . 'classwork or homework assignments. Answers included.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Computer Studies',
                    'code' => 'CST-S2',
                    'topics' => [
                        [
                            'title' => 'Introduction to Spreadsheets',
                            'competency_description' =>
                                'Learners should create, format, and use spreadsheets to organise data; write basic '
                                . 'formulae (SUM, AVERAGE, IF); produce charts; and apply spreadsheet skills to '
                                . 'practical problems such as a school tuck-shop stock register.',
                            'resources' => [
                                [
                                    'title'         => 'Google Sheets Full Tutorial for Beginners',
                                    'resource_type' => 'Video',
                                    'url'           => 'https://www.youtube.com/watch?v=TENAbUa-R-w',
                                    'annotation'    => 'Step-by-step 1-hour tutorial using free Google Sheets. '
                                                     . 'Ideal since most school computers have internet access to Google. '
                                                     . 'Covers all S2 syllabus functions.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Microsoft Excel Basics – GCFGlobal',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://edu.gcfglobal.org/en/excel/',
                                    'annotation'    => 'Free self-paced course with interactive lessons. '
                                                     . 'Useful where labs have Microsoft Office installed.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // ============================  SENIOR THREE  ============================ //
            $s3->id => [
                [
                    'name' => 'Biology',
                    'code' => 'BIO-S3',
                    'topics' => [
                        [
                            'title' => 'Genetics & Heredity',
                            'competency_description' =>
                                'Learners should explain Mendel\'s laws of inheritance, solve monohybrid and dihybrid '
                                . 'cross problems using Punnett squares, distinguish between dominant and recessive '
                                . 'alleles, and relate genetics to inherited conditions common in Uganda.',
                            'resources' => [
                                [
                                    'title'         => 'Genetics – CrashCourse Biology #9',
                                    'resource_type' => 'Video',
                                    'url'           => 'https://www.youtube.com/watch?v=CBezq1fFUEA',
                                    'annotation'    => 'Engaging and accurate overview of Mendelian genetics. '
                                                     . 'Watch before attempting Punnett square exercises.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Mendelian Genetics Simulation – BiologyCorner',
                                    'resource_type' => 'Simulation',
                                    'url'           => 'https://www.biologycorner.com/worksheets/punnett_practice.html',
                                    'annotation'    => 'Online Punnett square generator. Students input parent genotypes '
                                                     . 'and the tool shows offspring ratios. Good for self-checking.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Geography',
                    'code' => 'GEO-S3',
                    'topics' => [
                        [
                            'title' => 'Population Studies & Urbanisation',
                            'competency_description' =>
                                'Learners should analyse population distribution in Uganda, interpret population pyramids, '
                                . 'explain causes and effects of rural-urban migration, and evaluate government policies '
                                . 'on population management.',
                            'resources' => [
                                [
                                    'title'         => 'Uganda Population Data – UBOS (Uganda Bureau of Statistics)',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.ubos.org/explore-statistics/20/',
                                    'annotation'    => 'Primary source. Official Uganda census data, population pyramids, '
                                                     . 'and district-level statistics. Authoritative for any data-based '
                                                     . 'geography investigation.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'World Population Review – Uganda Profile',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://worldpopulationreview.com/countries/uganda-population',
                                    'annotation'    => 'Up-to-date population figures, growth rate, density map, '
                                                     . 'and demographic charts. Good supplementary reference.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // ============================  SENIOR FOUR  ============================ //
            $s4->id => [
                [
                    'name' => 'Mathematics',
                    'code' => 'MTH-S4',
                    'topics' => [
                        [
                            'title' => 'Calculus – Differentiation',
                            'competency_description' =>
                                'Learners should understand the concept of the derivative as a rate of change, '
                                . 'differentiate polynomial, trigonometric, and composite functions, and apply '
                                . 'differentiation to find maxima/minima in optimisation problems.',
                            'resources' => [
                                [
                                    'title'         => 'Calculus 1 – Full Course (Professor Leonard, YouTube)',
                                    'resource_type' => 'Video',
                                    'url'           => 'https://www.youtube.com/playlist?list=PLF797E961509B4EB5',
                                    'annotation'    => 'University-level but excellently explained. S4 students preparing '
                                                     . 'for UCE distinction should work through the first 10 videos.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Derivative Rules – Paul\'s Online Math Notes',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://tutorial.math.lamar.edu/Classes/CalcI/DerivativeIntro.aspx',
                                    'annotation'    => 'Comprehensive text-based notes with worked examples. '
                                                     . 'Good substitute when video is unavailable. Printable.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'History',
                    'code' => 'HST-S4',
                    'topics' => [
                        [
                            'title' => 'Pre-Colonial Kingdoms of Uganda',
                            'competency_description' =>
                                'Learners should describe the origin, political organisation, and economic activities '
                                . 'of the major pre-colonial kingdoms (Buganda, Bunyoro, Ankole, Busoga) and explain '
                                . 'how they influenced the formation of the modern Ugandan state.',
                            'resources' => [
                                [
                                    'title'         => 'Kingdom of Buganda – Official Website',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.buganda.or.ug/index.php/history',
                                    'annotation'    => 'Primary source from the Buganda Kingdom. Provides cultural context '
                                                     . 'and historical timeline. Encourage critical reading alongside textbook.',
                                    'is_verified'   => true,
                                ],
                                [
                                    'title'         => 'Uganda History – Britannica Overview',
                                    'resource_type' => 'Link',
                                    'url'           => 'https://www.britannica.com/place/Uganda/History',
                                    'annotation'    => 'Well-written encyclopaedic overview. Useful for introductory '
                                                     . 'research and essay preparation. Cite with care.',
                                    'is_verified'   => true,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // ------------------------------------------------------------------ //
        //  PERSIST CURRICULUM DATA
        // ------------------------------------------------------------------ //
        foreach ($curriculum as $classLevelId => $subjects) {
            foreach ($subjects as $subjectData) {
                $subject = Subject::firstOrCreate(
                    ['class_level_id' => $classLevelId, 'name' => $subjectData['name']],
                    ['code' => $subjectData['code']]
                );

                foreach ($subjectData['topics'] as $topicData) {
                    $topic = Topic::firstOrCreate(
                        ['subject_id' => $subject->id, 'title' => $topicData['title']],
                        ['competency_description' => $topicData['competency_description']]
                    );

                    foreach ($topicData['resources'] as $resourceData) {
                        Resource::firstOrCreate(
                            ['topic_id' => $topic->id, 'url' => $resourceData['url']],
                            [
                                'title'         => $resourceData['title'],
                                'resource_type' => $resourceData['resource_type'],
                                'annotation'    => $resourceData['annotation'],
                                'is_verified'   => $resourceData['is_verified'],
                            ]
                        );
                    }
                }
            }
        }

        $this->command->info('✅  Mengo Library seeded successfully!');
        $this->command->info('   Login → librarian@mengo.sc.ug  /  password123');
    }
}
