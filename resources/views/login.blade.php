<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloom Ads | Login</title>
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

        <section class="flex flex-col w-full items-center">
            <div class="relative w-[100%]">
                <img src="/images/lines.png" alt="lines" class="w-[100%] h-auto">
            </div>

            <div class="absolute bg-gradient-to-r from-[#FFE5C680] to-[#FFBB6780] p-20 lg:w-[40%] rounded-3xl items-center text-center mt-24">
                <h1 class="text-5xl font-bold text-black mb-5">Login</h1>
                <p class="text-2xl font-light mb-10">Welcome Back!</p>

                <div class="flex flex-col lg:px-5 gap-5 mb-10 ">
                    <a href="#" class="flex flex-row space-x-3 text-sm font-semibold text-center items-center justify-center text-white bg-[#1877F2] rounded-2xl px-8 p-2">
                        <svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="mr-2">
                            <rect width="40" height="40" fill="url(#pattern0_592_336)"/>
                            <defs>
                            <pattern id="pattern0_592_336" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_592_336" transform="scale(0.0111111)"/>
                            </pattern>
                            <image id="image0_592_336" width="90" height="90" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEn0lEQVR4nO2cTYhVZRjHXybTilKCyiKpNCXaaGHRB4YRUbTRXGhlHyBpDWFoTDVBi1okjIGLBJdnUYuiICtLEqWojbWY0dJKN+nYh9g4jboIZ+qOP3mYVzCT7jn3Pu/Xue8PzmaYe+7/+c2Zc96v8xqTyWQymUwmk8lkMplyABcAtwNPA28CHwN7gJ+BEWDMHiP2Z3vs76y3n7lNzlHy6zoLYAawFvgUOEH7HAe2AGuAa00nA1wMPAnsAMZxRwPYDjwBXGQ6BeBSe6X9jn+GgNeBaaauABcCLwF/Eh7J0COZTJ0A7gH2Eh/7gftN6sg9EdgEnCJeJNtGYIpJEeAG4FvSYQCYbVJC/h2Vmmm+kWbhfSYFgCXASdJlDHjExAzwjOM2sS+khlUmRoCHbeegLowDy0xMyH0NGKV+jAEPmBgA5iT64KvygLwxhnbyLuLgb+AI8BPQb3PJ6N6hs0b9WqU/aDvbdkZC3kM/A54H5gFdJfJeDaxs8fs2+rH639ALA/X4TgFvAze38Txp9XsX6JtsPkD0A/45BjzYZvZWRWMnGSbpmWweVkbhfHMCuFUhezuihRd0LDYPelmgoc7FSvnbFX1UxtQ1sjQL+jL+eV8xf7uihR6tPP83/SRNKN+ti5siE33Y6bQY8BT++UK5Bg3RwnLNXOeGlIlU36ytmHESsAh4Beg7z/GeUq5tLpcEhBiZu6NCxtnAPk+5ZADtGheiZd2Fb04Ck0vmmxKgbb/ahWhZ3OKbvRXyrQiQ7yMXy7SkV+abrytk/DxAvmOqy8/sWrgQbKmQ0Xez8wzzNUXL4sEQvFPhPy7U7M4KTdGyqjMERcl80wlHn6boTyIXPZNwbNYU/X2gIooERO/WFD0YqIgiAdEHNEWHWgFaJCD6qKbodiY26y56NHbR24HLmxyXlMzXVeJcZ44XlesY0xTtole4VS1gtVreUq5jWDPcr9RH9DblOgY1w8nsb11EH1Su4zvNcPIeX/KimZiK0x5T/1Az4AbqIfoWB3Ws1wz4bE1EL3NQx6rYr4StagHL1/GagzrmagbssstXUxf9rnINx9XfO3fQLNoP9DY5HiqZbVqJc/U6aHHoXyzAc/iniLwL3u1C9PQAsxhFxKLFxVXqom1BX3kupohY9JdOJNuClnsupohY9KOuF6C7GPdITfRvzndGAF71WFARqehep5LP2tjkSAeL/gOY6ly0LWx1B4vudm/43/fqfR0o+kevLwvZ4u700K4uIhI97v31N8fDp7GK1luR1OJAuuzcUnfRA8G3cgOus9uc1VX0sJzfxABwr6NtJIrAomWZxUITE/LCJfBPjUQ3ot3yx25L2aiB6AbwmIkZe2X/lbDo0Wiv5HMB7rYPkdREDwF3mZQArgd2JiR6p2yKaFLEvsXa18Z924do6fGt8961dgETyxW+iVD0ruRuFSXfnOq2g+ahRR+2i4Ka7sOULEy8SizDrL8EED1oZ/M7amf0LrtZ7Ad2KzVXoht2V4altduYuyrAFcDjdiXRsILoIXsu2V/kSvcVJAowy16Biyr8od6wn5lT63tvJpPJZDKZTCaTyRhlTgOVjgwH5mGZewAAAABJRU5ErkJggg=="/>
                            </defs>
                        </svg>
                        Login with Facebook
                    </a>

                    <a href="#" class="flex flex-row space-x-3 text-sm font-semibold text-center items-center justify-center text-white bg-[#181818] rounded-2xl px-8 p-2">
                        <svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="mr-2">
                            <rect width="40" height="40" fill="url(#pattern0_592_338)"/>
                            <defs>
                            <pattern id="pattern0_592_338" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_592_338" transform="scale(0.0104167)"/>
                            </pattern>
                            <image id="image0_592_338" width="96" height="96" xlink:href="data:image/png;base64,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"/>
                            </defs>
                        </svg>
                        Login with Google
                    </a>

                    <p>or</p>
                </div>

               <form class="space-y-6 w-full lg:px-5">
                    <div class="mb-3">
                        <label for="email"></label>
                        <input type="text" id="email" name="email" class="w-full p-2 px-5 border border-[#000000] rounded-xl" 
                        placeholder="Email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password"></label>
                        <input type="password" id="password" name="password" class="w-full p-2 px-5 border border-[#000000] rounded-xl" 
                        placeholder="Password" required>
                    </div>

                    <p class="font-semibold text-base">Forgot your password?</p>

                    <button type="submit" class="w-full py-2 bg-[#FF8C00] font-semibold text-black rounded-xl">Login</button>

                    <p class="font-semibold">Not Registered? <a href="/signup"><span class="text-[#FF8C00]">Sign Up Now</span></a></p>
               </form> 
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