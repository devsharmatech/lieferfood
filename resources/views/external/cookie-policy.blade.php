@extends('external.frame')
@section('external-css')
<style>
    .cookie-section {
        margin-bottom: 2.5rem;
    }
    .cookie-subsection {
        margin-bottom: 1.8rem;
    }
    .cookie-list {
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .cookie-list li {
        margin-bottom: 0.5rem;
    }
    .highlight-box {
        background-color: #f8f9fa;
        border-left: 4px solid #e23744;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border-radius: 0 4px 4px 0;
    }
    .contact-box {
        background-color: #f0f8ff;
        border: 1px solid #d1e7ff;
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }
    .section-title {
        color: #e23744;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .tech-definition {
        background-color: #f9f9f9;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 1.5rem;
        margin: 1rem 0;
    }
    .tech-definition h5 {
        color: #e23744;
        margin-bottom: 0.5rem;
    }
    .purpose-card {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        height: 100%;
    }
    .purpose-card h4 {
        color: #e23744;
        margin-bottom: 1rem;
    }
    .social-media-list {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin: 1rem 0;
    }
    .social-media-item {
        flex: 1 0 200px;
    }
</style>
@endsection

@section('external-home-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-0 border-0">
                <div class="card-body p-4">
                    <h1 class="text-center text-primary mb-4">Cookies Policy</h1>
                    
                    <div class="highlight-box">
                        <h4 class="text-primary">Cookie Statement</h4>
                        <p class="mb-0">This Cookie Statement ("Statement") applies to our websites, applications (collectively "Platform(s)") and email communications.</p>
                    </div>

                    <div class="cookie-section">
                        <p>Lieferfood.de ("we", "us", or "our") uses cookies, trackers, scripts and social media buttons (collectively: "Technologies") on our Platforms to help us deliver a better, faster and more secure experience. These Technologies are also placed by third parties who are engaged by us.</p>
                        
                        <p>This Statement is intended to explain to you what Technologies we use and why we use them. The use of Technologies may lead to processing of personal data. At Lieferfood.de we are committed to protecting the privacy of everyone in our community and make use of our Platforms, products and services (collectively: the "Service(s)"). If you would like to know more about how Lieferfood.de processes personal data, including our use of third party providers, please see our Privacy Statement. If you still have questions about our use of Technologies or the protection of your personal data in relation to the Technologies, please contact us at <a href="mailto:privacy@lieferfood.de">privacy@lieferfood.de</a>.</p>
                        
                        <div class="highlight-box">
                            <p><strong>Cookie Consent:</strong> When you first visit our Platforms from a device (i.e computer, smartphone or tablet) our cookie banner will appear where you can accept all Technologies or select your Technologies settings. You can always change your cookie settings via the manage your preferences section. However, blocking some types of Technologies may affect your experience on our Platforms and the Services we can provide.</p>
                        </div>
                    </div>

                    <div class="cookie-section">
                        <h2 class="section-title">Manage your Preferences</h2>
                        <p>Click <strong>Manage Preferences</strong> to adjust your Technologies preference.</p>
                        <p>We will always store Technologies on your device if they are necessary for operating the basic functionalities of our services as well as Technologies used to enable and maintain the proper functioning of our Platform. By clicking "Necessary Only" you can close the banner and only such necessary Technologies will be set. For all other types of Technologies, we ask your permission for each different purpose and function. Some Technologies are also placed by third party providers that appear on our pages.</p>
                        
                        <div class="highlight-box">
                            <p><strong>Important:</strong> Disabling certain Technologies may affect your experience on our Platforms and the Services we can provide.</p>
                        </div>
                        
                        <p>See our Technologies list for a specific overview of all the Technologies we use, as well as the purposes and functions associated with them, the cookie type, including their lifespan, as well as applied third party providers. This list is regularly updated by us to give you an accurate overview of the Technologies we use.</p>
                    </div>

                    <div class="cookie-section">
                        <h2 class="section-title">Why do we use these Technologies?</h2>
                        <p>We place cookies, trackers and scripts with different purposes: necessary, functional, analytical and personalised (targeting and advertising) purposes. Below you will find an overview of the different purposes for using the Technologies.</p>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="purpose-card">
                                    <h4>1. Necessary Technologies</h4>
                                    <p>These Technologies are necessary to ensure that our Platforms and their features function properly. Services you have asked for cannot be provided without these Technologies. We also use these Technologies to keep our Platform secure by monitoring and alerting potential cyber-attacks and fraudulent activities. Additionally, these Technologies help us to monitor the performance on our Platforms in order to detect technical problems and verify improvements and new features to make sure it does not interfere with the operation of the Platform's core functionality.</p>
                                    <div class="highlight-box mt-3 mb-0">
                                        <p class="mb-0"><strong>Example:</strong> These Technologies are required to be able to add items to your order or proceed to checkout.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="purpose-card">
                                    <h4>2. Functional Technologies</h4>
                                    <p>These Technologies allow the Platforms to remember the choices you make to give you better functionality and personal features. For instance, remembering your Platform preferences and choices, such as the language version you prefer, and remembering the address and other information you have included in order forms are examples of features which would not work without Technologies.</p>
                                    <div class="highlight-box mt-3 mb-0">
                                        <p class="mb-0"><strong>Note:</strong> The information collected through these Technologies is not used for marketing purposes.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="purpose-card">
                                    <h4>3. Analytical Technologies</h4>
                                    <p>These analytical Technologies, including statistics, are used to understand how visitors interact with the Platforms and we can measure and improve the performance of our Platforms. For instance, we keep track of which pages are visited the most and how you navigate on our Platform.</p>
                                    <div class="highlight-box mt-3 mb-0">
                                        <p class="mb-0"><strong>Purpose:</strong> Measure platform performance and user interaction patterns.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="purpose-card">
                                    <h4>4. Personalised Technologies</h4>
                                    <p>These marketing Technologies are used to tailor the delivery of information to you based upon your interests and to measure the effectiveness of advertisements, both on our Platforms and our advertising partners' websites. By means of marketing Technologies we can offer offers and/or discounts that may be of interest to you. For this purpose we analyse, among other things, how often you use our Platforms and with which Services you interact.</p>
                                    <div class="highlight-box mt-3 mb-0">
                                        <p class="mb-0"><strong>Additional use:</strong> Verify visits to advertiser websites for partnership payments.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="mt-4">For a specific overview of all Technologies used by us, the associated purposes and specific functions of the Technologies, please refer to our Technologies list. This list is regularly updated by us to provide you with an accurate overview of the Technologies we use.</p>
                    </div>

                    <div class="cookie-section">
                        <h2 class="section-title">What Technologies do we use?</h2>
                        <p>As mentioned above, we use various Technologies for data collection. Technologies used by us are scripts, trackers, cookies, pixels, web beacons, SDKs, social media buttons or similar technologies. Each Technology will be explained below.</p>
                        
                        <div class="tech-definition">
                            <h5>1. What is a script?</h5>
                            <p class="mb-0">A script is a piece of program code that is used to make our Platforms work properly and to make it interactive. This code can be executed on your server or on your equipment.</p>
                        </div>
                        
                        <div class="tech-definition">
                            <h5>2. What is a tracker?</h5>
                            <p class="mb-0">A tracker is a small invisible piece of text or image on our Platforms that is used to map the traffic. In order to map the traffic, we use several trackers, each of which stores different types of your data. Third parties may also place trackers on our Platforms to monitor the traffic.</p>
                        </div>
                        
                        <div class="tech-definition">
                            <h5>3. What are cookies?</h5>
                            <p>A cookie is a small text file that is sent from some of our Platforms and stored by your web browser on your device's hard drive. Some cookies only help to make the connection between your activities on our Platforms during your visit. Other cookies remain on your device's hard drive and are sent back to our servers or servers belonging to third parties who have placed cookies for us when you visit our Platforms again.</p>
                            <p class="mb-0">We use:</p>
                            <ul class="cookie-list">
                                <li><strong>First-party cookies:</strong> Our own cookies that are only set or retrieved by our Platforms when you are visiting it and/or you request our service.</li>
                                <li><strong>Third-Party cookies:</strong> Cookies sent to your device from a device or domain not managed by us, but by another entity that processes any data obtained through cookies.</li>
                            </ul>
                        </div>
                        
                        <div class="tech-definition">
                            <h5>4. What is a pixel?</h5>
                            <p class="mb-0">A pixel is a small piece of software, and consists of and are nearly invisible pixel-sized "dots" on our Platforms which create a link between your visit to our Platforms and the provider of the pixel, for instance social platforms like Facebook. Please note that when a pixel is placed, the pixel provider is able to follow your browsing behaviour across other websites which have implemented a similar pixel or Facebook social media button.</p>
                        </div>
                        
                        <div class="tech-definition">
                            <h5>5. What is a web beacon?</h5>
                            <p class="mb-0">A web beacon is a technique used on our Platform to allow checking what content you have accessed. We use web beacons to help us to understand your user journey through the Platform or a series of our Platforms.</p>
                        </div>
                        
                        <div class="tech-definition">
                            <h5>6. What is an SDK?</h5>
                            <p class="mb-0">An SDK is a software development kit, which consists of software tools and programs provided by hardware and software providers which our developers use to build applications for our Platforms. These providers make their SDKs available to help our developers easily integrate our apps with the hardware and software services providers. For example, the iOS SDK for Apple apps, the Java Development Kit for Android apps and the Cloud SDK for Google's Cloud Platform.</p>
                        </div>
                        
                        <div class="tech-definition">
                            <h5>7. What are social media buttons?</h5>
                            <p>Our Platforms also use social media buttons. A social media button (or 'plug-ins') are small pieces of software which create a link between your visit to our Platform and the social media platform of a third party provider. These buttons are available to promote websites ('likes') or shares ('tweets') on social networks such as Facebook, Twitter, or YouTube.</p>
                            <p>These buttons work using pieces of code that comes from Facebook, Twitter, and YouTube itself. These functionalities collect information about your social media interaction with us, such as whether or not you have an account with the social media site and whether you are logged into it when you interact with our content on our Platforms. This information may be linked to targeting/advertising activities.</p>
                            <div class="highlight-box mt-3">
                                <p class="mb-2"><strong>Important:</strong> We have no influence over how these social media parties make use of your personal data. These social media parties may also collect your personal data for their own purposes. For more information regarding these tracking Technologies set by the social media parties and the data that they may collect, please refer to their own privacy and cookies policies.</p>
                            </div>
                            
                            <h6 class="mt-4 mb-3">Social Media Platforms Used:</h6>
                            <div class="social-media-list">
                                <div class="social-media-item">
                                    <strong>Facebook</strong><br>
                                    <a href="https://www.facebook.com/policies/cookies/" target="_blank">Facebook Cookie Policy</a>
                                </div>
                                <div class="social-media-item">
                                    <strong>Instagram</strong><br>
                                    <a href="https://help.instagram.com/1896641480634370" target="_blank">Instagram Cookie Policy</a>
                                </div>
                                <div class="social-media-item">
                                    <strong>TikTok</strong><br>
                                    <a href="https://www.tiktok.com/legal/cookie-policy" target="_blank">TikTok Cookie Policy</a>
                                </div>
                                <div class="social-media-item">
                                    <strong>Snapchat</strong><br>
                                    <a href="https://www.snap.com/en-US/cookie-policy" target="_blank">Snapchat Cookie Policy</a>
                                </div>
                                <div class="social-media-item">
                                    <strong>Twitter</strong><br>
                                    <a href="https://help.twitter.com/en/rules-and-policies/twitter-cookies" target="_blank">Twitter Cookie Policy</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="highlight-box mt-4">
                            <h5>Technology Duration</h5>
                            <p class="mb-0">Please note that Technologies are either persistent, or session based. Persistent Technologies are stored on your device and have a certain expiration date. When the Technology expires it will automatically be deleted. If you revisit the Technology it will be renewed. Session based Technologies are placed on your device when you reach the Platform and will be deleted immediately after you leave the Platform.</p>
                        </div>
                    </div>

                    <div class="cookie-section">
                        <h2 class="section-title">Security of your data with us and with third parties</h2>
                        
                        <div class="cookie-subsection">
                            <h4 class="text-primary">1. Security for your data at Lieferfood.de</h4>
                            <p>Lieferfood.de takes the protection of your data seriously and takes appropriate precautions for prevention, loss, unauthorised access, unwanted disclosure and unjustified changes. If you believe that your data is not properly protected or that there are indications of misuse, please contact us via our <a href="#">privacy form</a>.</p>
                        </div>
                        
                        <div class="cookie-subsection">
                            <h4 class="text-primary">2. Third Party Technologies</h4>
                            <p>As mentioned above, we use third party Technologies. These third parties help us achieve the described objectives unless expressed otherwise in this Statement. We aim to not allow third parties to use your data for their own purposes or for purposes not consistent with the purposes described in this Statement. We remain responsible for the processing of your personal data by third parties on behalf of Lieferfood.de including third parties such as Google, Bing, Facebook and Twitter.</p>
                            <p>The third party is solely responsible for its use and processing of your personal data, e.g. targeted marketing on their own platforms. To learn how they process your personal data; you can view <a href="https://policies.google.com/privacy" target="_blank">Google's privacy terms and policy</a>. For other relevant third parties mentioned, please see the above shared links.</p>
                        </div>
                    </div>

                    <div class="cookie-section">
                        <h2 class="section-title">What are your rights?</h2>
                        
                        <div class="cookie-subsection">
                            <h4 class="text-primary">1. Enabling / Disabling and Deleting Technologies</h4>
                            <p>Except for necessary Technologies, you can actively consent to our use of Technologies, absent of which such Technologies will not be used. You can indicate your consent via our granular cookie consent banner, which appears when you first visit our Platform.</p>
                            <p>You can always adjust your consent preferences, i.e. change or withdraw your consent via the manage your preferences section above. Necessary Technologies for the operation of the Platform (including some scripts and cookies) can not be deactivated.</p>
                            
                            <div class="highlight-box">
                                <h6>Important Notes:</h6>
                                <ul class="cookie-list mb-0">
                                    <li>When you delete your Technologies from your device(s), Lieferfood.de may not always know that you have withdrawn your consent, which is why we recommend changing or withdrawing your consent settings on our Platform to make sure that your withdrawal of consent is properly administered.</li>
                                    <li>If you use multiple browsers, you will need to consent, change and/or withdraw your consent and/or delete Technologies specific to each browser as your preferences are unique to each browser instance used.</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="cookie-subsection">
                            <h4 class="text-primary">2. Your personal data rights</h4>
                            <p>To the extent the use of Technologies on our Platforms involves processing of personal data about you, you can exercise the rights provided for by applicable data protection laws. Relevant processing activities and rights are all listed in our Privacy Statement. To exercise your rights, please contact us via our <a href="#">privacy form</a>.</p>
                            <p>For the purpose of preventing abuse, we may ask you to identify yourself appropriately in the event of such a request.</p>
                        </div>
                        
                        <div class="cookie-subsection">
                            <h4 class="text-primary">3. Questions and complaints</h4>
                            <p>If you have any questions and/or complaints regarding this Statement, you can contact us via email or via our <a href="#">privacy form</a>.</p>
                        </div>
                    </div>

                    <div class="cookie-section">
                        <h2 class="section-title">Conclusion</h2>
                        <p>We may update this Statement from time to time in response to changing legal, technical or business developments. We reserve the right to amend the content of the Statement at any time. The revised Statement will be effective upon posting. If you are not happy with the revised Statement, you can alter your preferences and delete Technologies, or consider stopping using our Platforms.</p>
                        <p>We encourage you to periodically review this Statement for the latest information. We will keep prior versions of our Statement in an archive for your review.</p>
                        
                        <div class="contact-box">
                            <p class="mb-2"><strong>This Statement is subject to change and was last modified on 04.12.2024.</strong></p>
                            <p class="mb-0">For the latest version, please check this page periodically or contact us if you have any questions.</p>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <p><strong>Need help with your cookie preferences or have questions?</strong></p>
                        <a href="mailto:privacy@lieferfood.de" class="btn btn-primary me-3">Contact Privacy Team</a>
                        
                        <a href="{{ route('privacy-policy') }}" class="btn btn-secondary ms-3">View Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection