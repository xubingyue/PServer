#include <stdio.h>

extern "C"
{
#include "common.h"
}

int main(int argc, char *argv[])
{
	printf("%d\n", test());
    return 0;
}

