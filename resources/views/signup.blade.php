<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloom Ads | Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <section class="bg-white">
        <!-- desktop header -->
        <header class="md:flex flex-row w-full justify-between items-center bg-[#000000] py-8 px-16 hidden">
            <div class="w-1/5">
                <img src="/images/Bloomlogo.png" alt="" class="w-[107px] h-[35px]">
            </div>
        </header>

        <section class="flex flex-col justify-center w-full items-center">
            <div class="relative w-[100%]">
                <img src="/images/lines.png" alt="lines" class="w-[100%] h-full">
            </div>

            <div class="absolute bg-gradient-to-r from-[#FFE5C680] to-[#FFBB6780] p-20 rounded-3xl items-center text-center">
                <h1 class="text-5xl font-bold text-black mb-14">How do you plan <br>to collaborate with us?</h1>

                <div class="flex flex-col items-center gap-y-5 mx-32">
                    <a href="/signup1" class="text-center w-full p-8 border border-[#000000] rounded-3xl">
                        <p class="text-center text-xl font-semibold">Direct Advertiser</p>
                        <p class="text-center text-xs font-semibold">(I and my representative manages my advertising)</p>
                    </a>
                    
                    <a href="/signup2" class="text-center w-full p-8  border border-[#000000] rounded-3xl">
                        <p class="text-center text-xl font-semibold">Agency</p>
                        <p class="text-center text-xs font-semibold">(I manage advertising on behalf of my clients)</p>
                    </a>

                    <a href="/signup3" class="text-center w-full p-8 border border-[#000000] rounded-3xl">
                        <p class="text-center text-xl font-semibold">Partner</p>
                        <p class="text-center text-xs font-semibold">(I have a monthly ad budget of over 50,000 USD)</p>
                    </a>

                    <p class="font-semibold mt-5">Already Collaborating With Us? <a href="/login"><span class="text-[#FF8C00]">Login</span> </a></p>

                </div>
            </div>
        </section>
        
        
        <footer class="bg-black flex flex-col w-full lg:justify-center lg:items-center lg:py-14 lg:px-0 px-10">
            <div class="flex flex-col lg:flex-row lg:space-x-10 mb-10 text-white text-[14px] lg:text-3xl">
                <a href="">Service Agreement</a>
                <a href="">Purchase Policy</a>
                <a href="">Privacy Policy</a>
                <a href="">Contact Us</a>
            </div>

            <div class="flex flex-row lg:space-x-3 mb-10">
                <a href=""><img src="/images/Instagram.png" alt="instagram logo"></a>
                <a href=""><img src="/images/Facebook.png" alt="facebook logo"></a>
                <a href=""><img src="/images/LinkedIn.png" alt="linkedin logo"></a>
                <a href=""><img src="/images/TwitterX.png" alt="twitter logo"></a>
            </div>

            <div class="flex flex-row mb-5 space-x-2">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="mt-1">
                    <rect width="25" height="25" fill="url(#pattern0_561_390)"/>
                    <defs>
                    <pattern id="pattern0_561_390" patternContentUnits="objectBoundingBox" width="1" height="1">
                    <use xlink:href="#image0_561_390" transform="scale(0.0111111)"/>
                    </pattern>
                    <image id="image0_561_390" width="90" height="90" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAFcElEQVR4nO2da4jUVRTAr2VZWFaSlCSUWJShiVYfpIcSPSCKXmTgFqHVkihtZu+nINGDCNkIAqkPBfUhen9QE5QiLBZjfUIQayWZ2bKbPd0l7ReHPZINzcz9z5z7f94fzJdh5pxzz8zcxznnnnEuEolEIpFIJBKJRCJ+AEcCFwJ3AM8D7wNbgT5gEBjWx6A+t1Vf85y+5wKR4amuWgCTgHuBj4BfaJ99wIdAF3CaqzLAscBtwDrgIOE4AHwM3Aoc46oCcJx+03aTPj8By4ETXFkBjgIeAAbIHrFhmdjkygRwCbCN/PEVcLkrOjInAi8Df5NfxLZuYIwrIsAZwBcUhy+BM12RkJ+j0TYtbWRbeJkrAsANwH6KyzBwi8szQGfgPXFayBjucnkEuF4PB2XhIDDP5QmZ14AhyscwcKXLA8BZBV34kiyQU7J28hjdFpWdTZnus/UwUhW6szxW5/nEZ42MdU4WAaLtpMNO4A3gUaADuFoPRDcCi4AnNPAvc2loJMkwOk1HSxQudDhzBTA1YWZmNvCa7hZCsTSsd/8d0PEBQ52/Aw9LUsAgYxMqmNUvMXU7j9YfxIOEodd6GwVcBewJYOsySzvrpZ9+DGD4mna/xQ1sPgXYYWzvD0HTYprjs+bT0Lk8SdAC3xjb3RHSYEmkWvI9MCGYwf+1/RzjqOKaUIZOChCZu7bFqWCGJhYS1W8ATxraLgG0iUnt9zFS6i4sWZtA9zjgaWBXjQzZO78OnJsgZCBFN1YsacupdYyU4hZLZnvqPc9jfpXIYaenvEcMx/Be246tMW608clrS4Lpyrf+Q/bM8z1knm64vx40LT/TWjhLHvLU+05CuXKQGu8ht8dwLOebOFkNk+JBS6YH/HCbHpGBVwzHssDS0VLVacXPwCgPnS+FWmSN5+lnLB39gaFhGzx1ftei/D91v9/oIRVK+VsQZfEyNGyVh76TKQ69lo62PL4+5aFvDsVhp6WjLcOi93jok6B+Uei3dLRlIL3TQ9/tFIeh6OgCOtpy6ujyrN+r5NRhuRgu98ywV3IxtNzeveqh7yQqur2TdL4Vn3jqlDKDVuPEfU0ekmW34t28HsF/A47w0Plii/J7PGRLpj2XR3DroNJMD50zWwxnrvCQvSqvQSXrMOljnnrfSij3D4lhe8jdYDiWWSZOPqwKyDLwv8NT78SEwaVFHjJPNKzltg38q4Fyt9qSSz31TgW+biLrL+D+DKZBu4XwMAPlWrEl6xPoHqtXi7+tkfGrTi8zPOWMAjYajmFxW05tUIRifUflphbsmKDlBpOTVnYaFwDJr+jUpPb7GipdAizZE6Q24v9tHw/sNbR9dUhjpRWDNRtD1d3VTD2fGds9P3SRY4jqzPWhSmH1PvpaY3t3B+/9EbAIfRtwtrGt04zjNIe4z9LOLArR90uqq91vtzQ+kUNRoKvSUog+1s6jjQciTUVCMiAxBJ/6j5qt23TghcD3HpvG060vC6XV6GQX8CbwuC7G1+hlIUkO3K3Pv20ckavH5lQvC6mzL47X31JCO7dUhZVp+bVevbFc3y07PcDRmTlanT0lpcuUWSG1gpNdHgDmFrzrTD2knuUKlyeA60rYGOVml0ekPU5JWv0cAO50eUZb/hR5GhnKXYufJq1/9hV04ZvrioReyvmc4rAp85Y+be6zu3N+ghTbVma+TzY8rm8hf4hNF7kywchdxaUaZsyafk02pxsgShNG0kpdeuE+bfZqNn2cqwqMpJg6tFdHyIOOyF4tOb5KtZ5vUJG0RK6SafVPuwyqrMXBSgKKDiPlZ7OAhcCzUg2kbYD6NPNy6O9BBvS5Xn2NvHaBvjf+PUgkEolEIpFIJBKJOE/+AVhJq2eDC+U0AAAAAElFTkSuQmCC"/>
                    </defs>
                </svg>
                <p class="text-white text-xl">Copyright 2024</p>
            </div>
        </footer>
    </section>
</body> 
</html>