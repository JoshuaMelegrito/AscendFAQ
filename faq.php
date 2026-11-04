<?php
/**
 * mobile-homepage.php — ASCEND Mobile-First Kiosk
 * Layout: Full-screen sections (100dvh) with CSS Scroll Snapping.
 * Updated: Added ASCEND website link to FAQ + Chaindesk AI Chatbot.
 */

/* =========================================================
   RENDER HELPERS
   ========================================================= */
if (!function_exists('renderParamTable')) {
    function renderParamTable(array $tbl) {
        $h = '<div class="param-table-wrap"><table class="param-table">';
        if (!empty($tbl['head'])) {
            $h .= '<thead><tr>';
            foreach ($tbl['head'] as $th) $h .= '<th>' . htmlspecialchars($th) . '</th>';
            $h .= '</tr></thead>';
        }
        $h .= '<tbody>';
        foreach ($tbl['rows'] as $row) {
            $h .= '<tr>';
            foreach ($row as $cell) {
                if (is_array($cell)) {
                    $rs  = isset($cell['rowspan']) ? (int)$cell['rowspan'] : 1;
                    $cls = $rs > 1 ? ' class="rowspan-cell"' : '';
                    $h  .= '<td rowspan="' . $rs . '"' . $cls . '>' . htmlspecialchars($cell['text']) . '</td>';
                } else {
                    $h .= '<td>' . htmlspecialchars($cell) . '</td>';
                }
            }
            $h .= '</tr>';
        }
        $h .= '</tbody></table></div>';
        return $h;
    }
}
if (!function_exists('renderParamList')) {
    function renderParamList(array $items) {
        $html = '';
        foreach ($items as $item) {
            if (is_string($item)) {
                $html .= '<li>' . htmlspecialchars($item) . '</li>';
            } elseif (isset($item['table'])) {
                $html .= '<li class="no-bullet">' . renderParamTable($item['table']) . '</li>';
            } elseif (isset($item['text'])) {
                $html .= '<li class="has-subs"><span class="sub-title">'
                       . htmlspecialchars($item['text']) . '</span>';
                if (!empty($item['subs'])) {
                    $html .= '<ul class="sub-list">' . renderParamList($item['subs']) . '</ul>';
                }
                $html .= '</li>';
            }
        }
        return $html;
    }
}

/* =========================================================
   DATA: PARAMETERS
   ========================================================= */
$categories = [
    [
        'name'   => 'Protection & Safety',
        'icon'   => 'fa-shield',
        'color'  => '#7c3aed',
        'blurb'  => 'Grounding, lightning protection, emergency lighting, and panelboard documentation.',
        'source' => 'PEC 2017 · RA 9514 · NEC 408.4(A)',
        'parameters' => [
            [
                'no' => 1, 'title' => 'Grounding System',
                'purpose' => 'Verify compliance with PEC 2017, Article 2.50 – Grounding and Bonding.',
                'evidence' => [
                    'Photo Documentation — clear photos showing the installed grounding and bonding system.',
                ],
                'reference' => [
                    'AC systems shall be grounded when they meet conditions specified by the PEC.',
                ],
            ],
            [
                'no' => 2, 'title' => 'Lightning Protection',
                'purpose' => 'Verify compliance with PEC 2017, Article 2.90.',
                'evidence' => [
                    'Photo Documentation of air terminals and grounding connections.',
                ],
                'reference' => [
                    'Lightning protection systems shall safeguard persons and property.',
                ],
            ],
            [
                'no' => 3, 'title' => 'Emergency & Exit Lighting',
                'purpose' => 'Verify compliance with RA 9514 – Revised Fire Code.',
                'evidence' => [
                    'Valid FSIC from BFP.',
                    'Photo Documentation of installed emergency lights.',
                ],
                'reference' => [
                    'Requires BFP-issued Fire Safety Inspection Certificate (FSIC).',
                ],
            ],
            [
                'no' => 4, 'title' => 'Panelboard Labeling',
                'purpose' => 'Verify compliance with NEC Art. 408.4(A).',
                'evidence' => [
                    'Photo Documentation of completely-labeled panelboard directory.',
                ],
                'reference' => [
                    'Every circuit must be legibly identified.',
                ],
            ],
        ],
    ],
    [
        'name'   => 'Renewable Energy',
        'icon'   => 'fa-solar-panel',
        'color'  => '#3b82f6',
        'blurb'  => 'Solar PV availability and verified energy contribution.',
        'source' => 'BERDE 5.0.0',
        'parameters' => [
            [
                'no' => 1, 'title' => 'Solar PV Availability',
                'purpose' => 'Verify installed Solar PV system.',
                'evidence' => [
                    'Certificate of Final Electrical Inspection.',
                    'As-built plans signed by PEE.',
                    'Photo Documentation of installed panels.',
                ],
                'reference' => [
                    'One (1) of the listed documents is required.',
                ],
            ],
            [
                'no' => 2, 'title' => 'Energy Consumption Reduction',
                'purpose' => 'Verify the energy contribution of the Solar PV system.',
                'evidence' => [
                    '12 months of electricity bills before PV.',
                    'Single-line diagram and operation records.',
                ],
                'reference' => [
                    'Requires specific records based on configuration.',
                ],
            ],
        ],
    ],
    [
        'name'   => 'Energy Efficiency',
        'icon'   => 'fa-lightbulb',
        'color'  => '#10b981',
        'blurb'  => 'Lighting power density and recommended illuminance levels.',
        'source' => 'ASHRAE 90.1 · DC2020-12-0026',
        'parameters' => [
            [
                'no' => 1, 'title' => 'Lighting Power Density (LPD)',
                'purpose' => 'Verify compliance with the Philippine Green Building Code.',
                'evidence' => [
                    'As-built plans showing floor area and schedule of loads.',
                    'Photos showing wattage of lighting loads.',
                ],
                'reference' => [
                    ['table' => [
                        'head' => ['Use / Occupancy', 'Max LPD (W/m²)'],
                        'rows' => [
                            ['Residential / Hotel', '10.8'],
                            ['Educational / Hospital', '12.9'],
                            ['Business: Office', '10.8'],
                            ['Mercantile: Mall', '16.1'],
                        ],
                    ]],
                ],
            ],
        ],
    ],
    [
        'name'   => 'Power Quality',
        'icon'   => 'fa-wave-square',
        'color'  => '#f59e0b',
        'blurb'  => 'Power factor, voltage regulation, and harmonic distortion.',
        'source' => 'PDC 2001',
        'parameters' => [
            [
                'no' => 1, 'title' => 'Power Factor',
                'purpose' => 'Verify compliance with PDC 2001.',
                'evidence' => [
                    'Electric bill showing power factor, OR Analysis report.',
                ],
                'reference' => [
                    'User shall maintain a Power Factor not less than 85% (0.85) lagging.',
                ],
            ],
            [
                'no' => 2, 'title' => 'Voltage Regulation',
                'purpose' => 'Verify allowable voltage variation.',
                'evidence' => [
                    'Analysis report showing voltage variation values.',
                ],
                'reference' => [
                    'Allowable variation is within ±5% of nominal voltage.',
                ],
            ],
            [
                'no' => 3, 'title' => 'Harmonic Distortion',
                'purpose' => 'Verify THD and TDD compliance.',
                'evidence' => [
                    'Analysis report on Harmonic Distortion.',
                ],
                'reference' => [
                    'THD and TDD shall not exceed 5% during normal operations.',
                ],
            ],
        ],
    ],
];

$ratingCriteria = [
    ['stars' => '★★★★★', 'range' => '90% – 100%', 'label' => 'Exemplary',   'class' => 'excellent'],
    ['stars' => '★★★★☆', 'range' => '80% – 89%',  'label' => 'High',        'class' => 'very-good'],
    ['stars' => '★★★☆☆', 'range' => '70% – 79%',  'label' => 'Substantial', 'class' => 'good'],
    ['stars' => '★★☆☆☆', 'range' => '60% – 69%',  'label' => 'Satisfactory','class' => 'fair'],
    ['stars' => '★☆☆☆☆', 'range' => '50% – 59%',  'label' => 'Basic',       'class' => 'poor'],
    ['stars' => '☆☆☆☆☆', 'range' => '0% – 49%',   'label' => 'Below Basic', 'class' => 'below'],
];

/* =========================================================
   DATA: FAQ
   ========================================================= */
$faqs = [
    [
        'q' => 'What is ASCEND?',
        'a' => 'ASCEND is a web-based decision support system designed to benchmark, evaluate, and rate the electrical performance of low-rise sustainable buildings in the Philippines. The platform translates building assessment parameters into a transparent, star-based compliance rating.'
    ],
    [
        'q' => 'Where can I see the ASCEND website?',
        'a' => 'You can visit the official ASCEND website at:<br><br>
                <a href="https://ascendph.infinityfree.me/homepage.php" target="_blank" style="color: var(--primary); font-weight: 600; text-decoration: underline; word-break: break-all;">https://ascendph.infinityfree.me/homepage.php</a>'
    ],
    [
        'q' => 'Who can use this platform?',
        'a' => 'The system features two primary user roles:<br><br>
                <strong>1. Clients / Applicants:</strong> Building owners or facility managers who upload technical documents and track their building\'s evaluation status.<br><br>
                <strong>2. Assessors:</strong> Qualified electrical professionals or inspectors who review the uploaded documentation and evaluate the parameters using a structured scorecard system.'
    ],
    [
        'q' => 'What regulatory guidelines are used?',
        'a' => 'Evaluations are strictly grounded in the Philippine Electrical Code (PEC), the Building for Ecologically Responsive Design Excellence (BERDE) framework, and recognized international standards (such as IEC, IEEE, and LEED).'
    ],
    [
        'q' => 'What parameters does ASCEND evaluate?',
        'a' => 'The platform evaluates building performance across four key electrical categories:<br><br>
                • <strong>Protection & Safety:</strong> Grounding resistance, lightning protection systems (LPS), emergency & exit lighting, and panelboard labeling.<br>
                • <strong>Renewable Energy:</strong> Solar PV System Installation, Energy Consumption Reduction, and Battery Energy Storage System (BESS).<br>
                • <strong>Energy Efficiency:</strong> Lighting Power Density, and Lightning Controls / Occupancy Sensors.<br>
                • <strong>Power Quality:</strong> Power Factor, and Voltage Regulation.'
    ],
    [
        'q' => 'Does the platform include on-site physical testing?',
        'a' => 'No. ASCEND is a software-based decision support tool. Evaluations are performed by qualified assessors based entirely on the official, available building plans, reports, bills, and technical data sheets uploaded by the client.'
    ],
    [
        'q' => 'What documents do I need to submit?',
        'a' => 'Clients must upload 10 core technical documents or verification packages to complete their submission:<br><br>
                1. Documentation of Grounding System<br>
                2. Documentation of Lightning Protection System<br>
                3. Fire Safety Inspection Certificate & Photo Documentation of Emergency/Exit Lighting<br>
                4. Photo Documentation of Panelboard Directory<br>
                5. Certificate of Final Electrical Inspection, As-built Plans, Certificate of Compliance, or Photo Documentation of Installed Solar PV System<br>
                6. 12-Month Electricity Bills, Single-line Diagram, Solar PV Operation Records, and Energy Records<br>
                7. As-built Plans or Photo Documentation of Lighting Loads Used<br>
                8. Photo Documentation on Power Factor<br>
                9. Analysis Report on Voltage Regulation from Power Quality Analyzer<br>
                10. Analysis Report on Harmonic Distortion from Power Quality Analyzer'
    ],
    [
        'q' => 'What file formats and sizes are accepted?',
        'a' => 'The system accepts PDF, JPG, PNG, and DOCX file formats. Each uploaded file must have a maximum size of 10MB.'
    ],
    [
        'q' => 'Can I modify a submission after it has been sent?',
        'a' => 'No. If you have an active submission currently under review, you cannot submit a new layout or edit documents until the assessor has finished evaluating it or until you delete the active pending submission.'
    ],
    [
        'q' => 'How does the Star Rating Scale work?',
        'a' => 'Once an assessor completes the scorecard evaluation, your total points are calculated as a percentage. Ratings are tier-based:<br><br>
                • <strong>90.00% - 100.00%:</strong> Exemplary Compliance<br>
                • <strong>80.00% - 89.99%:</strong> High Compliance<br>
                • <strong>70.00% - 79.99%:</strong> Substantial Compliance<br>
                • <strong>60.00% - 69.99%:</strong> Satisfactory Compliance<br>
                • <strong>50.00% - 59.99%:</strong> Basic Compliance<br>
                • <strong>0% - 49.99%:</strong> Below Basic Compliance'
    ],
    [
        'q' => 'How do I register or log in?',
        'a' => 'Click the "Sign Up" or "Create one here" link on our portal. Enter your full name, email, contact number, address, and select your respective user role to create your profile.'
    ],
    [
        'q' => 'Who do I contact for technical issues?',
        'a' => 'For any account modifications, system errors, or evaluation concerns, please reach out to our team directly at <strong>ascendsupport.ph@gmail.com</strong>.'
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>ASCEND — Electrical Performance Rating</title>
<link rel="icon" type="image/png" href="logo.png">
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
    /* =========================================================
       FULL SCREEN MOBILE ARCHITECTURE
       ========================================================= */
    *,*::before,*::after { margin:0; padding:0; box-sizing:border-box; }

    :root {
        --primary:#4c3f91; --primary-dark:#2d1f6b;
        --accent:#c084fc; --accent-light:#e9d5ff;
        --text-dark:#0f172a; --text-muted:#475569; --text-light:#94a3b8;
        --bg-glass: rgba(255, 255, 255, 0.65);
        --bg-glass-heavy: rgba(255, 255, 255, 0.85);
        --border-glass: rgba(255, 255, 255, 0.9);
        --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.05);
        --radius: 20px;
    }

    html { 
        scroll-behavior: smooth; 
        -webkit-text-size-adjust: 100%; 
    }

    body {
        font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--text-dark);
        line-height: 1.6;
        background: url('background.png') center/cover no-repeat fixed;
        height: 100dvh; 
        overflow: hidden; 
    }

    body::before {
        content: ''; position: fixed; inset: 0;
        background: linear-gradient(180deg, rgba(255,255,255,0.4) 0%, rgba(240,242,248,0.8) 100%);
        z-index: -1;
    }

    /* ===================== STICKY HEADER ===================== */
    .mobile-header {
        position: fixed; top: 0; left: 0; width: 100%; z-index: 1000;
        background: var(--bg-glass-heavy);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid var(--border-glass);
        padding: 12px 20px;
        display: flex; justify-content: space-between; align-items: center;
    }
    
    .brand {
        display: flex; align-items: center; gap: 10px;
        text-decoration: none; color: var(--primary);
        font-family: 'Fraunces', serif; font-size: 1.3rem; font-weight: 700;
    }
    .brand img { height: 28px; width: auto; }

    .menu-btn {
        background: none; border: none; font-size: 1.4rem; color: var(--primary);
        padding: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center;
    }

    /* ===================== MOBILE NAV DRAWER ===================== */
    .mobile-nav {
        position: fixed; top: 60px; left: 0; width: 100%; height: calc(100dvh - 60px);
        background: var(--bg-glass-heavy);
        backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
        z-index: 999; display: flex; flex-direction: column;
        padding: 2rem; gap: 1rem;
        transform: translateY(-100%); opacity: 0; pointer-events: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .mobile-nav.open { transform: translateY(0); opacity: 1; pointer-events: auto; }
    
    .mobile-nav a {
        text-decoration: none; color: var(--text-dark);
        font-size: 1.2rem; font-weight: 600; padding: 1rem;
        border-radius: 12px; background: rgba(255,255,255,0.5);
        border: 1px solid var(--border-glass);
        display: flex; justify-content: space-between; align-items: center;
    }
    .mobile-nav a:active { background: var(--accent-light); }

    /* ===================== MAIN SCROLL CONTAINER ===================== */
    main {
        height: 100dvh;
        overflow-y: auto;
        scroll-snap-type: y mandatory; 
        scroll-behavior: smooth;
        scroll-padding-top: 60px; 
        padding-top: 60px; 
        padding-bottom: 20px;
    }

    /* ===================== FULL SCREEN SECTIONS ===================== */
    .section {
        min-height: calc(100dvh - 60px); 
        scroll-snap-align: start; 
        display: flex; flex-direction: column;
        padding: 20px;
        position: relative;
    }

    /* HOME / HERO - Centered */
    #home {
        justify-content: center; 
        text-align: left;
    }
    
    .eyebrow {
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 1.5px; color: var(--primary-dark);
        background: var(--accent-light); padding: 0.4rem 0.8rem;
        border-radius: 50px; width: fit-content; margin-bottom: 1rem;
        border: 1px solid rgba(255,255,255,0.5);
    }

    .hero h1 {
        font-family: 'Fraunces', serif; font-size: 2.2rem;
        font-weight: 700; line-height: 1.2; letter-spacing: -0.5px;
        margin-bottom: 1rem;
    }
    .hero h1 span {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }

    .hero p {
        font-size: 0.95rem; color: var(--text-muted); line-height: 1.7;
    }

    /* Scroll Hint */
    .scroll-hint {
        position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%);
        display: flex; flex-direction: column; align-items: center; gap: 5px;
        font-size: 0.75rem; font-weight: 600; color: var(--primary);
        animation: bounce 2s infinite; cursor: pointer;
    }
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0) translateX(-50%); }
        40% { transform: translateY(-8px) translateX(-50%); }
        60% { transform: translateY(-4px) translateX(-50%); }
    }

    /* ===================== ABOUT ===================== */
    #about {
        justify-content: flex-start; 
        align-items: center;
        text-align: center;
        padding-top: 30px; 
    }
    
    .section-header {
        margin-bottom: 1.5rem;
        width: 100%;
    }
    .section-tag {
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 1.5px; color: var(--accent); margin-bottom: 0.2rem;
    }
    .section-header h2 {
        font-family: 'Fraunces', serif; font-size: 1.6rem;
        font-weight: 700; line-height: 1.3;
    }
    
    #about p {
        font-size: 0.95rem; color: var(--text-muted); margin-top: 1rem; 
        max-width: 90%; line-height: 1.7;
    }
    
    .about-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem;
        margin-top: 2rem; width: 100%; text-align: left;
    }
    .about-card {
        background: var(--bg-glass);
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--border-glass);
        padding: 1rem; border-radius: var(--radius);
        display: flex; flex-direction: column; gap: 0.5rem; align-items: center; text-align: center;
        box-shadow: var(--shadow-sm);
    }
    .about-card .icon-box {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1rem; flex-shrink: 0;
    }
    .about-card h3 { font-size: 0.85rem; color: var(--primary); margin-bottom: 2px; }
    .about-card p { font-size: 0.7rem; margin-top: 0; line-height: 1.4; }

    /* ===================== PARAMETERS & FAQ ===================== */
    #parameters, #faq {
        justify-content: flex-start; 
        overflow-y: auto; 
    }

    .rating-box {
        background: var(--bg-glass);
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--border-glass);
        border-radius: var(--radius); padding: 1rem;
        margin-bottom: 1rem; box-shadow: var(--shadow-sm);
    }
    .rating-box h3 { font-size: 0.95rem; margin-bottom: 0.8rem; color: var(--primary); display: flex; align-items: center; gap: 8px;}
    
    .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%; }
    .rating-table { width: 100%; border-collapse: collapse; font-size: 0.75rem; }
    .rating-table th { text-align: left; padding: 6px; color: var(--text-muted); border-bottom: 2px solid var(--accent-light); }
    .rating-table td { padding: 8px 6px; border-bottom: 1px solid rgba(255,255,255,0.4); }
    .rating-table tr:last-child td { border-bottom: none; }
    .stars { color: #f5b342; letter-spacing: 1px; }
    .label { font-weight: 700; font-size: 0.7rem; }

    .category-accordion {
        background: var(--bg-glass);
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--border-glass);
        border-radius: var(--radius);
        margin-bottom: 0.8rem; box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    .category-accordion summary {
        padding: 1rem; cursor: pointer; list-style: none;
        display: flex; align-items: center; gap: 0.8rem;
        font-weight: 600; color: var(--text-dark); font-size: 0.9rem;
    }
    .category-accordion summary::-webkit-details-marker { display: none; }
    
    .category-accordion summary .icon-box {
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 0.8rem; flex-shrink: 0;
    }
    .category-accordion summary .chevron {
        margin-left: auto; color: var(--primary); transition: transform 0.3s;
    }
    .category-accordion[open] summary .chevron { transform: rotate(180deg); }
    
    .accordion-content { padding: 0 1rem 1rem 1rem; }
    .source-text {
        font-size: 0.65rem; color: var(--text-light); margin-bottom: 0.8rem;
        padding-bottom: 0.5rem; border-bottom: 1px dashed rgba(0,0,0,0.1);
    }

    .param-card {
        background: rgba(255,255,255,0.7);
        border-radius: 12px; padding: 0.8rem;
        margin-bottom: 0.8rem; border: 1px solid rgba(0,0,0,0.05);
    }
    .param-card:last-child { margin-bottom: 0; }
    .param-header { display: flex; gap: 8px; margin-bottom: 0.6rem; }
    .param-num {
        width: 22px; height: 22px; border-radius: 6px;
        background: var(--primary); color: white;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 700; flex-shrink: 0;
    }
    .param-header h4 { font-size: 0.85rem; color: var(--text-dark); line-height: 1.3; }
    
    .param-section { margin-top: 0.6rem; }
    .param-section h5 {
        font-size: 0.6rem; text-transform: uppercase; letter-spacing: 1px;
        color: var(--primary); margin-bottom: 0.3rem;
    }
    .param-section ul { list-style: none; padding: 0; }
    .param-section ul li {
        font-size: 0.75rem; color: var(--text-muted);
        padding-left: 12px; position: relative; margin-bottom: 3px;
    }
    .param-section ul li::before {
        content: '•'; position: absolute; left: 0; color: var(--accent); font-weight: bold;
    }
    .param-table-wrap { overflow-x: auto; margin-top: 0.4rem; }
    .param-table { width: 100%; border-collapse: collapse; font-size: 0.7rem; }
    .param-table th { background: var(--accent-light); padding: 4px; text-align: left; color: var(--primary-dark); }
    .param-table td { padding: 4px; border-bottom: 1px solid rgba(0,0,0,0.05); color: var(--text-muted); }

    /* FAQ */
    .faq-item {
        background: var(--bg-glass);
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--border-glass);
        border-radius: var(--radius); margin-bottom: 0.8rem;
        overflow: hidden;
    }
    .faq-q {
        width: 100%; text-align: left; background: none; border: none;
        padding: 1rem; font-family: inherit; font-size: 0.9rem; font-weight: 600;
        color: var(--text-dark); cursor: pointer;
        display: flex; justify-content: space-between; align-items: center; gap: 10px;
    }
    .faq-q .faq-icon {
        width: 22px; height: 22px; border-radius: 50%; background: var(--accent-light);
        color: var(--primary); display: flex; align-items: center; justify-content: center;
        font-size: 0.65rem; flex-shrink: 0; transition: transform 0.3s;
    }
    .faq-item.open .faq-q .faq-icon { transform: rotate(45deg); background: var(--primary); color: white; }
    
    .faq-a {
        max-height: 0; overflow: hidden; transition: max-height 0.3s ease;
        padding: 0 1rem;
    }
    /* Increased max-height to fit the longer 10-item list */
    .faq-item.open .faq-a { max-height: 1200px; }
    .faq-a p { font-size: 0.8rem; color: var(--text-muted); padding-bottom: 1rem; line-height: 1.6; }

    /* ===================== DESKTOP OVERRIDES ===================== */
    @media (min-width: 768px) {
        body { overflow: auto; height: auto; }
        main { height: auto; overflow: visible; scroll-snap-type: none; padding-top: 80px; }
        
        .mobile-header { padding: 15px 40px; }
        .menu-btn { display: none; }
        
        .mobile-nav {
            position: static; transform: none; opacity: 1; pointer-events: auto;
            width: auto; height: auto; background: none; backdrop-filter: none;
            padding: 0; flex-direction: row; gap: 1.5rem;
        }
        .mobile-nav a {
            background: none; border: none; padding: 0.5rem; font-size: 1rem; color: var(--text-muted);
        }
        
        .section { 
            min-height: 100vh; scroll-snap-align: none; 
            max-width: 1000px; margin: 0 auto; padding: 80px 40px; 
            justify-content: center; 
        }
        .hero h1 { font-size: 3.5rem; }
        .about-grid { grid-template-columns: repeat(4, 1fr); }
        .about-card { padding: 1.5rem; }
        .about-card h3 { font-size: 1.1rem; }
        .about-card p { font-size: 0.85rem; }
        
        .scroll-hint { display: none; }
        .rating-box, .category-accordion, .faq-item { border-radius: 24px; }
    }
</style>
</head>
<body>

<!-- ===================== STICKY HEADER ===================== -->
<header class="mobile-header">
    <a href="#home" class="brand">
        <img src="logo.png" alt="ASCEND" /> ASCEND
    </a>
    
    <button class="menu-btn" id="menuBtn" aria-label="Toggle Menu">
        <i class="fas fa-bars"></i>
    </button>

    <nav class="mobile-nav" id="mobileNav">
        <a href="#home" class="active">Home <i class="fas fa-chevron-right" style="font-size:0.8rem; opacity:0.5;"></i></a>
        <a href="#about">About <i class="fas fa-chevron-right" style="font-size:0.8rem; opacity:0.5;"></i></a>
        <a href="#parameters">Parameters <i class="fas fa-chevron-right" style="font-size:0.8rem; opacity:0.5;"></i></a>
        <a href="#faq">FAQ <i class="fas fa-chevron-right" style="font-size:0.8rem; opacity:0.5;"></i></a>
    </nav>
</header>

<main>

    <!-- ===================== 1. HERO (HOME) ===================== -->
    <section id="home" class="section">
        <div class="hero">
            <p class="eyebrow">Assessor-Guided Rating</p>
            <h1>Elevate building compliance with <span>ASCEND</span>.</h1>
            <p>A systematic web-based platform that evaluates sustainable buildings across protection, safety, renewable energy, energy efficiency, and power quality.</p>
        </div>
        
        <div class="scroll-hint" onclick="document.getElementById('about').scrollIntoView({behavior: 'smooth'});">
            <span>Swipe up</span> 
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- ===================== 2. ABOUT ===================== -->
    <section id="about" class="section">
        <div class="section-header">
            <p class="section-tag">About</p>
            <h2>A standards-based rating platform for sustainable buildings.</h2>
        </div>
        
        <p><strong>ASCEND</strong> (Assessor-guided Standards-based Compliance and Energy Performance Decision-support) supports a systematic evaluation of buildings on their electrical performance, grounded by key local and international regulatory policies.</p>

        <div class="about-grid">
            <?php foreach ($categories as $cat): ?>
                <div class="about-card">
                    <div class="icon-box" style="background: <?= htmlspecialchars($cat['color']) ?>;">
                        <i class="fas <?= htmlspecialchars($cat['icon']) ?>"></i>
                    </div>
                    <div>
                        <h3><?= htmlspecialchars($cat['name']) ?></h3>
                        <p><?= htmlspecialchars($cat['blurb']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ===================== 3. PARAMETERS ===================== -->
    <section id="parameters" class="section">
        <div class="section-header">
            <p class="section-tag">Parameters</p>
            <h2>Assessment & evidence requirements.</h2>
        </div>

        <!-- Star Rating Box -->
        <div class="rating-box">
            <h3><i class="fas fa-star" style="color:var(--accent);"></i> Star Rating Scale</h3>
            <div class="table-scroll">
                <table class="rating-table">
                    <thead>
                        <tr>
                            <th>Stars</th>
                            <th>Score</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ratingCriteria as $r): ?>
                        <tr>
                            <td><span class="stars"><?= $r['stars'] ?></span></td>
                            <td style="font-weight:600; font-size:0.75rem;"><?= $r['range'] ?></td>
                            <td><span class="label" style="color:var(--primary);"><?= $r['label'] ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Parameters Accordions -->
        <?php foreach ($categories as $cat): ?>
            <details class="category-accordion">
                <summary>
                    <div class="icon-box" style="background: <?= htmlspecialchars($cat['color']) ?>;">
                        <i class="fas <?= htmlspecialchars($cat['icon']) ?>"></i>
                    </div>
                    <span><?= htmlspecialchars($cat['name']) ?></span>
                    <i class="fas fa-chevron-down chevron"></i>
                </summary>
                
                <div class="accordion-content">
                    <p class="source-text">Source: <?= htmlspecialchars($cat['source']) ?></p>
                    
                    <?php foreach ($cat['parameters'] as $p): ?>
                        <div class="param-card">
                            <div class="param-header">
                                <div class="param-num"><?= $p['no'] ?></div>
                                <h4><?= htmlspecialchars($p['title']) ?></h4>
                            </div>
                            
                            <div class="param-section">
                                <h5>Purpose</h5>
                                <ul><li><?= htmlspecialchars($p['purpose']) ?></li></ul>
                            </div>
                            
                            <div class="param-section">
                                <h5>Evidence / Docs</h5>
                                <ul><?= renderParamList($p['evidence']) ?></ul>
                            </div>
                            
                            <div class="param-section">
                                <h5>Reference</h5>
                                <ul><?= renderParamList($p['reference']) ?></ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </details>
        <?php endforeach; ?>
    </section>

    <!-- ===================== 4. FAQ ===================== -->
    <section id="faq" class="section">
        <div class="section-header">
            <p class="section-tag">FAQ</p>
            <h2>Frequently Asked Questions.</h2>
        </div>

        <?php foreach ($faqs as $f): ?>
            <div class="faq-item">
                <button class="faq-q" type="button">
                    <span><?= $f['q'] ?></span>
                    <div class="faq-icon"><i class="fas fa-plus"></i></div>
                </button>
                <div class="faq-a">
                    <p><?= $f['a'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        
        <div style="margin-top: auto; padding-top: 2rem; text-align: center; font-size: 0.8rem; color: var(--text-light);">
            <p>© <?= date('Y') ?> ASCEND. All rights reserved.</p>
            <a href="#home" style="color: var(--primary); text-decoration: none; font-weight: 600; display: block; margin-top: 0.5rem;">Back to top</a>
        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Mobile Menu Toggle
    const menuBtn = document.getElementById('menuBtn');
    const mobileNav = document.getElementById('mobileNav');
    const menuIcon = menuBtn.querySelector('i');

    menuBtn.addEventListener('click', function() {
        const isOpen = mobileNav.classList.toggle('open');
        if(isOpen) {
            menuIcon.classList.replace('fa-bars', 'fa-times');
        } else {
            menuIcon.classList.replace('fa-times', 'fa-bars');
        }
    });

    // Close menu when a link is clicked
    mobileNav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileNav.classList.remove('open');
            menuIcon.classList.replace('fa-times', 'fa-bars');
        });
    });

    // 2. Simple FAQ Accordion
    const faqBtns = document.querySelectorAll('.faq-q');
    faqBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            
            document.querySelectorAll('.faq-item').forEach(el => el.classList.remove('open'));
            if (!isOpen) {
                item.classList.add('open');
            }
        });
    });

    // 3. Smooth Scrolling & Snap logic
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if(targetId === '#') return;
            
            const target = document.querySelector(targetId);
            if(target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>

<!-- ===================== CHAINDESK AI CHATBOT ===================== -->
<script type="module">
  import Chatbox from 'https://cdn.jsdelivr.net/npm/@chaindesk/embeds@latest/dist/chatbox/index.js';

  const widget = await Chatbox.initBubble({
    agentId: 'cmw21grw90000jj04y4b0pyfj',
    
    // optional 
    // If provided will create a contact for the user and link it to the conversation
    contact: {
      firstName: 'Guest',
      lastName: 'User',
      email: 'customer@email.com',
      phoneNumber: '+33612345644',
      userId: '42424242',
    },
    // optional
    // Override initial messages
    initialMessages: [
      'Hello! Welcome to ASCEND.',
      'How can I help you today?',
    ],
    // optional
    // Provided context will be appended to the Agent system prompt
    context: "The user you are talking to is visiting the ASCEND mobile FAQ page.",
  });

  // You can uncomment one of these if you want the chatbot to auto-open
  // widget.open(); 
  // widget.toggle();
</script>

</body>
</html>